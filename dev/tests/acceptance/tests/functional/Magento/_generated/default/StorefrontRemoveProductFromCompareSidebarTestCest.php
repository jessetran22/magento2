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
 * @Title("MC-35068: Verify that the product isn't removed on clicking the product name")
 * @Description("Verify that the product isn't removed on clicking the product name, but it's redirected to product page<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/StorefrontRemoveProductFromCompareSidebarTest.xml<br>")
 * @group Catalog
 * @TestCaseId("MC-35068")
 */
class StorefrontRemoveProductFromCompareSidebarTestCest
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
		$I->createEntity("defaultCategory", "hook", "_defaultCategory", [], []); // stepKey: defaultCategory
		$I->createEntity("simpleProduct", "hook", "SimpleProduct", ["defaultCategory"], []); // stepKey: simpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("defaultCategory", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"Verify that the product isn't removed on clicking the product name"})
	 * @Features({"Catalog"})
	 * @Severity(level = SeverityLevel::TRIVIAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontRemoveProductFromCompareSidebarTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openCategoryPage] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Open category page on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('defaultCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateStorefrontCategoryPageOpenCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadOpenCategoryPage
		$I->comment("Exiting Action Group [openCategoryPage] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Entering Action Group [addProductToCompareList] StorefrontAddCategoryProductToCompareActionGroup");
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('simpleProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAddProductToCompareList
		$I->click("//*[contains(@class,'product-item-info')][descendant::a[contains(text(), '" . $I->retrieveEntityField('simpleProduct', 'name', 'test') . "')]]//a[contains(@class, 'tocompare')]"); // stepKey: clickAddProductToCompareAddProductToCompareList
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: waitForAddCategoryProductToCompareSuccessMessageAddProductToCompareList
		$I->see("You added product " . $I->retrieveEntityField('simpleProduct', 'name', 'test') . " to the comparison list.", "div.message-success.success.message"); // stepKey: assertAddCategoryProductToCompareSuccessMessageAddProductToCompareList
		$I->comment("Exiting Action Group [addProductToCompareList] StorefrontAddCategoryProductToCompareActionGroup");
		$I->comment("Entering Action Group [clickOnComparingProductLink] StorefrontClickOnProductFromSidebarCompareListActionGroup");
		$I->waitForElementVisible("//main//ol[@id='compare-items']//a[@class='product-item-link'][text()='" . $I->retrieveEntityField('simpleProduct', 'name', 'test') . "']", 30); // stepKey: waitForAddedCompareProductClickOnComparingProductLink
		$I->click("//main//ol[@id='compare-items']//a[@class='product-item-link'][text()='" . $I->retrieveEntityField('simpleProduct', 'name', 'test') . "']"); // stepKey: clickOnProductLinkClickOnComparingProductLink
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadClickOnComparingProductLink
		$I->comment("Exiting Action Group [clickOnComparingProductLink] StorefrontClickOnProductFromSidebarCompareListActionGroup");
		$I->comment("Entering Action Group [checkProductPageUrl] StorefrontCheckProductUrlActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('simpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlCheckProductPageUrl
		$I->comment("Exiting Action Group [checkProductPageUrl] StorefrontCheckProductUrlActionGroup");
	}
}
