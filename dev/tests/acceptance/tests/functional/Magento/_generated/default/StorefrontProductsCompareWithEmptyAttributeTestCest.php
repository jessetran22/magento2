<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MAGETWO-91960: Product attribute is not visible on product compare page if it is empty")
 * @Description("Product attribute should not be visible on the product compare page if it is empty for all products that are being compared, not even displayed as N/A<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/StorefrontProductsCompareWithEmptyAttributeTest.xml<br>")
 * @TestCaseId("MAGETWO-91960")
 * @group productCompare
 */
class StorefrontProductsCompareWithEmptyAttributeTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createProductAttribute", "hook", "productAttributeWithDropdownTwoOptions", [], []); // stepKey: createProductAttribute
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct1", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct1
		$I->createEntity("createSimpleProduct2", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct2
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createProductAttribute", "hook"); // stepKey: deleteProductAttribute
		$I->deleteEntity("createSimpleProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("createSimpleProduct2", "hook"); // stepKey: deleteSimpleProduct2
		$I->comment("Entering Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin
		$I->comment("Exiting Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Features({"Catalog"})
	 * @Stories({"Product attributes"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontProductsCompareWithEmptyAttributeTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin1
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin1
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin1
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin1
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin1WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin1
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin1
		$I->comment("Exiting Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/"); // stepKey: amOnAttributeSetPage
		$I->click("//td[contains(text(), 'Default')]"); // stepKey: chooseDefaultAttributeSet
		$I->waitForPageLoad(30); // stepKey: waitForAttributeSetPageLoad
		$I->dragAndDrop("//span[text()='testattribute']", "//span[text()='Product Details']"); // stepKey: moveProductAttributeToGroup
		$I->click("button[title='Save']"); // stepKey: saveAttributeSet
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappear
		$I->seeElement(".message-success"); // stepKey: assertSuccess
		$I->comment("Entering Action Group [clearCache] ClearCacheActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/cache"); // stepKey: goToCacheManagementClearCache
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClearCache
		$I->click("#flush_magento"); // stepKey: clickFlushMagentoCacheClearCache
		$I->waitForPageLoad(30); // stepKey: waitForCacheFlushClearCache
		$I->comment("Exiting Action Group [clearCache] ClearCacheActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goProductPageOnStorefront1
		$I->comment("View simple product 1");
		$I->click("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]"); // stepKey: browseClickCategorySimpleProduct1View
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSimpleProduct1Viewloaded
		$I->comment("View Simple Product 1");
		$I->comment("Entering Action Group [compareAddSimpleProduct1ToCompare] StorefrontAddProductToCompareActionGroup");
		$I->click("a.action.tocompare"); // stepKey: clickAddToCompareCompareAddSimpleProduct1ToCompare
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: waitForAddProductToCompareSuccessMessageCompareAddSimpleProduct1ToCompare
		$I->see("You added product " . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . " to the comparison list.", "div.message-success.success.message"); // stepKey: assertAddProductToCompareSuccessMessageCompareAddSimpleProduct1ToCompare
		$I->comment("Exiting Action Group [compareAddSimpleProduct1ToCompare] StorefrontAddProductToCompareActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goProductPageOnStorefront2
		$I->comment("View simple product 2");
		$I->click("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "')]"); // stepKey: browseClickCategorySimpleProduct2View
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSimpleProduct2Viewloaded
		$I->comment("View Simple Product 2");
		$I->comment("Entering Action Group [compareAddSimpleProduct2ToCompare] StorefrontAddProductToCompareActionGroup");
		$I->click("a.action.tocompare"); // stepKey: clickAddToCompareCompareAddSimpleProduct2ToCompare
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: waitForAddProductToCompareSuccessMessageCompareAddSimpleProduct2ToCompare
		$I->see("You added product " . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . " to the comparison list.", "div.message-success.success.message"); // stepKey: assertAddProductToCompareSuccessMessageCompareAddSimpleProduct2ToCompare
		$I->comment("Exiting Action Group [compareAddSimpleProduct2ToCompare] StorefrontAddProductToCompareActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goProductPageOnStorefront3
		$I->comment("Check simple product 1 in comparison sidebar");
		$I->comment("Entering Action Group [compareSimpleProduct1InSidebar] StorefrontCheckCompareSidebarProductActionGroup");
		$I->waitForElement("//main//ol[@id='compare-items']//a[@class='product-item-link'][text()='" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "']", 30); // stepKey: waitForProductCompareSimpleProduct1InSidebar
		$I->comment("Exiting Action Group [compareSimpleProduct1InSidebar] StorefrontCheckCompareSidebarProductActionGroup");
		$I->comment("Entering Action Group [compareSimpleProduct2InSidebar] StorefrontCheckCompareSidebarProductActionGroup");
		$I->waitForElement("//main//ol[@id='compare-items']//a[@class='product-item-link'][text()='" . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . "']", 30); // stepKey: waitForProductCompareSimpleProduct2InSidebar
		$I->comment("Exiting Action Group [compareSimpleProduct2InSidebar] StorefrontCheckCompareSidebarProductActionGroup");
		$I->comment("Check products in comparison sidebar");
		$I->comment("Check simple product 1 in comparison sidebar");
		$I->comment("Check simple product2 in comparison sidebar");
		$I->comment("Check products on comparison page");
		$I->comment("Check simple product 1 on comparison page");
		$I->comment("Check simple product 1 on comparison page");
		$I->comment("Entering Action Group [compareOpenComparePage] StorefrontOpenAndCheckComparisionActionGroup");
		$I->click("//main//div[contains(@class, 'block-compare')]//a[contains(@class, 'action compare')]"); // stepKey: clickCompareCompareOpenComparePage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForComparePageloadedCompareOpenComparePage
		$I->seeInCurrentUrl("catalog/product_compare/index"); // stepKey: checkUrlCompareOpenComparePage
		$I->seeInTitle("Products Comparison List"); // stepKey: assertPageNameInTitleCompareOpenComparePage
		$I->see("Compare Products", "//*[@id='maincontent']//h1//span"); // stepKey: assertPageNameCompareOpenComparePage
		$I->comment("Exiting Action Group [compareOpenComparePage] StorefrontOpenAndCheckComparisionActionGroup");
		$I->comment("Entering Action Group [compareAssertSimpleProduct1InComparison] StorefrontCheckCompareSimpleProductActionGroup");
		$I->seeElement("//*[@id='product-comparison']//tr//strong[@class='product-item-name']/a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]"); // stepKey: assertProductNameCompareAssertSimpleProduct1InComparison
		$I->see("$" . $I->retrieveEntityField('createSimpleProduct1', 'price', 'test') . ".00", "//*[@id='product-comparison']//td[.//strong[@class='product-item-name']/a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: assertProductPrice1CompareAssertSimpleProduct1InComparison
		$I->see($I->retrieveEntityField('createSimpleProduct1', 'sku', 'test'), "//*[@id='product-comparison']//tr[.//th[./span[contains(text(), 'SKU')]]]//td[count(//*[@id='product-comparison']//tr//td[.//strong[@class='product-item-name']/a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]/preceding-sibling::td)+1]/div"); // stepKey: assertProductPrice2CompareAssertSimpleProduct1InComparison
		$I->comment("@TODO: MAGETWO-80272 Move to Magento_Checkout");
		$I->seeElement("//*[@id='product-comparison']//td[.//strong[@class='product-item-name']/a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: assertProductAddToCartCompareAssertSimpleProduct1InComparison
		$I->comment("Exiting Action Group [compareAssertSimpleProduct1InComparison] StorefrontCheckCompareSimpleProductActionGroup");
		$I->seeElement("//table[@id='product-comparison']/tbody/tr/th/*[contains(text(),'SKU')]"); // stepKey: seeCompareAttribute1
		$I->dontSeeElement("//table[@id='product-comparison']/tbody/tr/th/*[contains(text(),'testattribute')]"); // stepKey: seeCompareAttribute2
	}
}
