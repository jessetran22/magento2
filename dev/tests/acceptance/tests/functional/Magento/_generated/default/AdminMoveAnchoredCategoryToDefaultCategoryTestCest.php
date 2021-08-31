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
 * @Title("MC-6493: Move default anchored subcategory with anchored parent to default subcategory")
 * @Description("Login as admin,move anchored subcategory with anchored parent to default subcategory<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminMoveAnchoredCategoryToDefaultCategoryTest.xml<br>")
 * @TestCaseId("MC-6493")
 * @group mtf_migrated
 */
class AdminMoveAnchoredCategoryToDefaultCategoryTestCest
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
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->createEntity("createDefaultCategory", "hook", "_defaultCategory", [], []); // stepKey: createDefaultCategory
		$I->createEntity("simpleProduct", "hook", "defaultSimpleProduct", [], []); // stepKey: simpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createDefaultCategory", "hook"); // stepKey: deleteDefaultCategory
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Stories({"Move categories"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMoveAnchoredCategoryToDefaultCategoryTest(AcceptanceTester $I)
	{
		$I->comment("Open Category Page");
		$I->comment("Entering Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenAdminCategoryIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenAdminCategoryIndexPage
		$I->comment("Exiting Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [clickOnExpandTree] AdminExpandCategoryTreeActionGroup");
		$I->click(".tree-actions a:last-child"); // stepKey: clickOnExpandTreeClickOnExpandTree
		$I->waitForPageLoad(30); // stepKey: waitForCategoryToLoadClickOnExpandTree
		$I->comment("Exiting Action Group [clickOnExpandTree] AdminExpandCategoryTreeActionGroup");
		$I->click("//a/span[contains(text(), 'simpleCategory" . msq("_defaultCategory") . "')]"); // stepKey: selectCategory
		$I->waitForPageLoad(30); // stepKey: selectCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad
		$I->comment("Enable Anchor for _defaultCategory Category");
		$I->scrollTo("//strong[@class='admin__collapsible-title']//span[text()='Display Settings']", 0, -80); // stepKey: scrollToDisplaySetting
		$I->click("//strong[@class='admin__collapsible-title']//span[text()='Display Settings']"); // stepKey: selectDisplaySetting
		$I->checkOption("input[name='is_anchor']"); // stepKey: enableAnchor
		$I->comment("Entering Action Group [saveSubCategory] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveSubCategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveSubCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveSubCategory
		$I->comment("Exiting Action Group [saveSubCategory] AdminSaveCategoryActionGroup");
		$I->seeElement(".message-success"); // stepKey: seeSuccessMessage
		$I->comment("Enable Anchor for FirstLevelSubCat Category");
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddSubCategoryButton
		$I->waitForPageLoad(30); // stepKey: clickOnAddSubCategoryButtonWaitForPageLoad
		$I->fillField("input[name='name']", "FirstLevelSubCategory" . msq("FirstLevelSubCat")); // stepKey: addSubCategoryName
		$I->scrollTo("//strong[@class='admin__collapsible-title']//span[text()='Display Settings']", 0, -80); // stepKey: scrollToDisplaySetting1
		$I->click("//strong[@class='admin__collapsible-title']//span[text()='Display Settings']"); // stepKey: selectDisplaySetting1
		$I->checkOption("input[name='is_anchor']"); // stepKey: enableAnchor1
		$I->comment("Entering Action Group [saveSubCategory1] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveSubCategory1
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveSubCategory1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveSubCategory1
		$I->comment("Exiting Action Group [saveSubCategory1] AdminSaveCategoryActionGroup");
		$I->seeElement(".message-success"); // stepKey: seeSuccessMessage1
		$I->comment("Enable Anchor for SimpleSubCategory Category and add products to the Category");
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddSubCategoryButton1
		$I->waitForPageLoad(30); // stepKey: clickOnAddSubCategoryButton1WaitForPageLoad
		$I->fillField("input[name='name']", "SimpleSubCategory" . msq("SimpleSubCategory")); // stepKey: addSubCategoryName1
		$I->scrollTo("//strong[@class='admin__collapsible-title']//span[text()='Display Settings']", 0, -80); // stepKey: scrollToDisplaySetting2
		$I->click("//strong[@class='admin__collapsible-title']//span[text()='Display Settings']"); // stepKey: selectDisplaySetting2
		$I->checkOption("input[name='is_anchor']"); // stepKey: enableAnchor2
		$I->scrollTo("div[data-index='assign_products']", 0, -80); // stepKey: scrollToProductInCategory1
		$I->waitForPageLoad(30); // stepKey: scrollToProductInCategory1WaitForPageLoad
		$I->click("div[data-index='assign_products']"); // stepKey: clickOnProductInCategory
		$I->waitForPageLoad(30); // stepKey: clickOnProductInCategoryWaitForPageLoad
		$I->fillField("#catalog_category_products_filter_name", $I->retrieveEntityField('simpleProduct', 'name', 'test')); // stepKey: selectProduct
		$I->click("//button[@data-action='grid-filter-apply']"); // stepKey: clickSearchButton
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonWaitForPageLoad
		$I->click("#catalog_category_products_table tbody tr"); // stepKey: selectProductFromTableRow
		$I->comment("Entering Action Group [saveSubCategory2] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveSubCategory2
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveSubCategory2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveSubCategory2
		$I->comment("Exiting Action Group [saveSubCategory2] AdminSaveCategoryActionGroup");
		$I->seeElement(".message-success"); // stepKey: seeSuccessMessage2
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Open Category in store front page");
		$I->amOnPage("/" . $I->retrieveEntityField('createDefaultCategory', 'custom_attributes[url_key]', 'test') . "/firstlevelsubcategory" . msq("FirstLevelSubCat") . "/simplesubcategory" . msq("SimpleSubCategory") . ".html"); // stepKey: seeTheCategoryInStoreFrontPage
		$I->waitForPageLoad(30); // stepKey: waitForStoreFrontPageLoad
		$I->seeElement("//nav//a[span[contains(., 'simpleCategory" . msq("_defaultCategory") . "')]]"); // stepKey: seeDefaultCategoryOnStoreNavigationBar
		$I->waitForPageLoad(30); // stepKey: seeDefaultCategoryOnStoreNavigationBarWaitForPageLoad
		$I->dontSeeElement("//nav//a[span[contains(., 'SimpleSubCategory" . msq("SimpleSubCategory") . "')]]"); // stepKey: dontSeeSubCategoryOnStoreNavigationBar
		$I->waitForPageLoad(30); // stepKey: dontSeeSubCategoryOnStoreNavigationBarWaitForPageLoad
		$I->comment("<Verify breadcrumbs in store front page");
		$breadcrumbs = $I->grabMultiple(".breadcrumbs li"); // stepKey: breadcrumbs
		$I->assertEquals(['Home', $I->retrieveEntityField('createDefaultCategory', 'name', 'test'), "FirstLevelSubCategory" . msq("FirstLevelSubCat"), "SimpleSubCategory" . msq("SimpleSubCategory")], $breadcrumbs); // stepKey: verifyTheCategoryInStoreFrontPage
		$I->comment("Verify Product displayed in category store front page");
		$I->click("a.product-item-link"); // stepKey: openSearchedProduct
		$I->waitForPageLoad(30); // stepKey: openSearchedProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoad1
		$I->see("Testp" . msq("defaultSimpleProduct"), ".base"); // stepKey: assertProductName
		$I->comment("Open Category Page");
		$I->comment("Entering Action Group [openAdminCategoryIndexPage1] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenAdminCategoryIndexPage1
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenAdminCategoryIndexPage1
		$I->comment("Exiting Action Group [openAdminCategoryIndexPage1] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [clickOnExpandTree2] AdminExpandCategoryTreeActionGroup");
		$I->click(".tree-actions a:last-child"); // stepKey: clickOnExpandTreeClickOnExpandTree2
		$I->waitForPageLoad(30); // stepKey: waitForCategoryToLoadClickOnExpandTree2
		$I->comment("Exiting Action Group [clickOnExpandTree2] AdminExpandCategoryTreeActionGroup");
		$I->comment("Move SubCategory under Default Category");
		$I->dragAndDrop("//a/span[contains(text(), 'SimpleSubCategory" . msq("SimpleSubCategory") . "')]", "//a/span[contains(text(), 'Default Category')]"); // stepKey: moveCategory
		$I->waitForPageLoad(30); // stepKey: moveCategoryWaitForPageLoad
		$I->see("This operation can take a long time", "aside.confirm div.modal-content"); // stepKey: seeWarningMessage
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: clickOkButtonOnWarningPopup
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad3
		$I->see("You moved the category.", ".message-success"); // stepKey: seeSuccessMoveMessage
		$I->amOnPage("/simplesubcategory" . msq("SimpleSubCategory") . ".html"); // stepKey: seeTheCategoryInStoreFrontPage1
		$I->waitForPageLoad(30); // stepKey: waitForStoreFrontPageLoad1
		$I->comment("Verify breadcrumbs in store front page after the move");
		$breadcrumbsAfterMove = $I->grabMultiple(".breadcrumbs li"); // stepKey: breadcrumbsAfterMove
		$I->assertEquals(['Home', "SimpleSubCategory" . msq("SimpleSubCategory")], $breadcrumbsAfterMove); // stepKey: verifyBreadcrumbsInFrontPageAfterMove
		$I->comment("Open Category in store front");
		$I->amOnPage("/simplesubcategory" . msq("SimpleSubCategory") . ".html"); // stepKey: amOnCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToBeLoaded
		$I->seeElement("#page-title-heading span"); // stepKey: seeCategoryInTitle
		$I->seeElement("//nav//a[span[contains(., 'SimpleSubCategory" . msq("SimpleSubCategory") . "')]]"); // stepKey: seeCategoryOnStoreNavigationBarAfterMove
		$I->waitForPageLoad(30); // stepKey: seeCategoryOnStoreNavigationBarAfterMoveWaitForPageLoad
		$I->click("a.product-item-link"); // stepKey: openSearchedProduct1
		$I->waitForPageLoad(30); // stepKey: openSearchedProduct1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoad2
		$I->comment("Verify product name on Store Front");
		$I->see("Testp" . msq("defaultSimpleProduct"), ".base"); // stepKey: assertProductNameAfterMove
	}
}
