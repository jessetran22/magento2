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
 * @Title("[NO TESTCASEID]: Product attribute without value in compare list test")
 * @Description("The product attribute that has no value should output 'N/A' on the product comparison page.<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/ProductAttributeWithoutValueInCompareListTest.xml<br>")
 * @group Catalog
 */
class ProductAttributeWithoutValueInCompareListTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->createEntity("createProductAttribute", "hook", "textProductAttribute", [], []); // stepKey: createProductAttribute
		$I->createEntity("createAttributeSet", "hook", "CatalogAttributeSet", [], []); // stepKey: createAttributeSet
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/edit/id/" . $I->retrieveEntityField('createAttributeSet', 'attribute_set_id', 'hook') . "/"); // stepKey: onAttributeSetEdit
		$I->comment("Entering Action Group [assignAttributeToGroup] AssignAttributeToGroupActionGroup");
		$I->conditionalClick("//*[@id='tree-div1']//span[text()='Product Details']", "//*[@id='tree-div1']//span[text()='Product Details']/parent::*/parent::*[contains(@class, 'collapsed')]", true); // stepKey: extendGroupAssignAttributeToGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1AssignAttributeToGroup
		$I->dragAndDrop("//*[@id='tree-div2']//span[text()='" . $I->retrieveEntityField('createProductAttribute', 'attribute_code', 'hook') . "']", "//*[@id='tree-div1']//span[text()='Product Details']/parent::*/parent::*/parent::*//li[1]//a/span"); // stepKey: dragAndDropToGroupProductDetailsAssignAttributeToGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2AssignAttributeToGroup
		$I->see($I->retrieveEntityField('createProductAttribute', 'attribute_code', 'hook'), "#tree-div1"); // stepKey: seeAttributeInGroupAssignAttributeToGroup
		$I->comment("Exiting Action Group [assignAttributeToGroup] AssignAttributeToGroupActionGroup");
		$I->comment("Entering Action Group [SaveAttributeSet] SaveAttributeSetActionGroup");
		$I->click("button[title='Save']"); // stepKey: clickSaveSaveAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickSaveSaveAttributeSetWaitForPageLoad
		$I->see("You saved the attribute set", "#messages div.message-success"); // stepKey: successMessageSaveAttributeSet
		$I->comment("Exiting Action Group [SaveAttributeSet] SaveAttributeSetActionGroup");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProductDefault", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createProductDefault
		$I->createEntity("createProductCustom", "hook", "SimpleProductWithCustomAttributeSet", ["createCategory", "createAttributeSet"], []); // stepKey: createProductCustom
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createProductDefault", "hook"); // stepKey: deleteProductDefault
		$I->deleteEntity("createProductCustom", "hook"); // stepKey: deleteProductCustom
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createAttributeSet", "hook"); // stepKey: deleteAttributeSet
		$I->deleteEntity("createProductAttribute", "hook"); // stepKey: deleteProductAttribute
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Stories({"Product Comparison"})
	 * @Severity(level = SeverityLevel::TRIVIAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function ProductAttributeWithoutValueInCompareListTest(AcceptanceTester $I)
	{
		$I->comment("Open product page");
		$I->amOnPage("/" . $I->retrieveEntityField('createProductDefault', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductDefaultPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPage
		$I->comment("Click on 'Add to Compare' link");
		$I->comment("Entering Action Group [clickOnAddToCompare] StorefrontAddProductToCompareActionGroup");
		$I->click("a.action.tocompare"); // stepKey: clickAddToCompareClickOnAddToCompare
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: waitForAddProductToCompareSuccessMessageClickOnAddToCompare
		$I->see("You added product " . $I->retrieveEntityField('createProductDefault', 'name', 'test') . " to the comparison list.", "div.message-success.success.message"); // stepKey: assertAddProductToCompareSuccessMessageClickOnAddToCompare
		$I->comment("Exiting Action Group [clickOnAddToCompare] StorefrontAddProductToCompareActionGroup");
		$I->comment("See product in the comparison list");
		$I->comment("Entering Action Group [seeProductDefaultInComparisonListActionGroup] SeeProductInComparisonListActionGroup");
		$I->amOnPage("catalog/product_compare/index"); // stepKey: navigateToComparePageSeeProductDefaultInComparisonListActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductComparePageLoadSeeProductDefaultInComparisonListActionGroup
		$I->seeElement("//*[@id='product-comparison']//tr//strong[@class='product-item-name']/a[contains(text(), '" . $I->retrieveEntityField('createProductDefault', 'name', 'test') . "')]"); // stepKey: seeProductInCompareListSeeProductDefaultInComparisonListActionGroup
		$I->comment("Exiting Action Group [seeProductDefaultInComparisonListActionGroup] SeeProductInComparisonListActionGroup");
		$I->comment("Open product with custom attribute page");
		$I->amOnPage("/" . $I->retrieveEntityField('createProductCustom', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductCustomPage
		$I->waitForPageLoad(30); // stepKey: waitForProductCustomPage
		$I->comment("Click on 'Add to Compare' link");
		$I->comment("Entering Action Group [clickOnAddToCompareCustom] StorefrontAddProductToCompareActionGroup");
		$I->click("a.action.tocompare"); // stepKey: clickAddToCompareClickOnAddToCompareCustom
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: waitForAddProductToCompareSuccessMessageClickOnAddToCompareCustom
		$I->see("You added product " . $I->retrieveEntityField('createProductCustom', 'name', 'test') . " to the comparison list.", "div.message-success.success.message"); // stepKey: assertAddProductToCompareSuccessMessageClickOnAddToCompareCustom
		$I->comment("Exiting Action Group [clickOnAddToCompareCustom] StorefrontAddProductToCompareActionGroup");
		$I->comment("See product with custom attribute in the comparison list");
		$I->comment("Entering Action Group [seeProductCustomInComparisonListActionGroup] SeeProductInComparisonListActionGroup");
		$I->amOnPage("catalog/product_compare/index"); // stepKey: navigateToComparePageSeeProductCustomInComparisonListActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductComparePageLoadSeeProductCustomInComparisonListActionGroup
		$I->seeElement("//*[@id='product-comparison']//tr//strong[@class='product-item-name']/a[contains(text(), '" . $I->retrieveEntityField('createProductCustom', 'name', 'test') . "')]"); // stepKey: seeProductInCompareListSeeProductCustomInComparisonListActionGroup
		$I->comment("Exiting Action Group [seeProductCustomInComparisonListActionGroup] SeeProductInComparisonListActionGroup");
		$I->comment("See attribute default value in the comparison list");
		$I->see($I->retrieveEntityField('createProductAttribute', 'defaultValue', 'test'), "//*[@id='product-comparison']//tr[.//th[./span[contains(text(), 'attribute" . msq("ProductAttributeFrontendLabel") . "')]]]//td[count(//*[@id='product-comparison']//tr//td[.//strong[@class='product-item-name']/a[contains(text(), '" . $I->retrieveEntityField('createProductCustom', 'name', 'test') . "')]]/preceding-sibling::td)+1]/div"); // stepKey: assertAttributeValueForProductCustom
		$I->comment("See N/A if attribute has no value in the comparison list");
		$I->see("N/A", "//*[@id='product-comparison']//tr[.//th[./span[contains(text(), 'attribute" . msq("ProductAttributeFrontendLabel") . "')]]]//td[count(//*[@id='product-comparison']//tr//td[.//strong[@class='product-item-name']/a[contains(text(), '" . $I->retrieveEntityField('createProductDefault', 'name', 'test') . "')]]/preceding-sibling::td)+1]/div"); // stepKey: assertNAForProductDefault
	}
}
