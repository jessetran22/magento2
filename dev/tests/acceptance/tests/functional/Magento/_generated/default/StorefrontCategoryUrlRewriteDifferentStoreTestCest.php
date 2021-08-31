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
 * @Title("MC-38053: Verify url category for different store view.")
 * @Description("Verify url category for different store view, after change ukr_key category for one of them store view.<h3>Test files</h3>app/code/Magento/CatalogUrlRewrite/Test/Mftf/Test/StorefrontCategoryUrlRewriteDifferentStoreTest.xml<br>")
 * @TestCaseId("MC-38053")
 */
class StorefrontCategoryUrlRewriteDifferentStoreTestCest
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
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$setEnableUseCategoriesPath = $I->magentoCLI("config:set catalog/seo/product_use_categories 1", 60); // stepKey: setEnableUseCategoriesPath
		$I->comment($setEnableUseCategoriesPath);
		$I->createEntity("rootCategory", "hook", "SubCategory", [], []); // stepKey: rootCategory
		$I->createEntity("subCategory", "hook", "SimpleSubCategoryDifferentUrlStore", ["rootCategory"], []); // stepKey: subCategory
		$I->createEntity("createProduct", "hook", "_defaultProduct", ["subCategory"], []); // stepKey: createProduct
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [createCustomStoreViewFr] CreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: amOnAdminSystemStoreViewPageCreateCustomStoreViewFr
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadCreateCustomStoreViewFr
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreGroupCreateCustomStoreViewFr
		$I->fillField("#store_name", "FR" . msq("customStoreFR")); // stepKey: fillStoreViewNameCreateCustomStoreViewFr
		$I->fillField("#store_code", "fr" . msq("customStoreFR")); // stepKey: fillStoreViewCodeCreateCustomStoreViewFr
		$I->selectOption("#store_is_active", "1"); // stepKey: selectStoreViewStatusCreateCustomStoreViewFr
		$I->click("#save"); // stepKey: clickSaveStoreViewButtonCreateCustomStoreViewFr
		$I->waitForPageLoad(90); // stepKey: clickSaveStoreViewButtonCreateCustomStoreViewFrWaitForPageLoad
		$I->waitForElementVisible(".action-primary.action-accept", 30); // stepKey: waitForAcceptNewStoreViewCreationButtonCreateCustomStoreViewFr
		$I->conditionalClick(".action-primary.action-accept", ".action-primary.action-accept", true); // stepKey: clickAcceptNewStoreViewCreationButtonCreateCustomStoreViewFr
		$I->see("You saved the store view."); // stepKey: seeSavedMessageCreateCustomStoreViewFr
		$I->comment("Exiting Action Group [createCustomStoreViewFr] CreateStoreViewActionGroup");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$setEnableUseCategoriesPath = $I->magentoCLI("config:set catalog/seo/product_use_categories 0", 60); // stepKey: setEnableUseCategoriesPath
		$I->comment($setEnableUseCategoriesPath);
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("subCategory", "hook"); // stepKey: deleteSubCategory
		$I->deleteEntity("rootCategory", "hook"); // stepKey: deleteRootCategory
		$I->comment("Entering Action Group [deleteStoreView] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteStoreView
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreViewWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "FR" . msq("customStoreFR")); // stepKey: fillStoreViewFilterFieldDeleteStoreView
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteStoreViewWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteStoreViewWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteStoreViewWaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteStoreView
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteStoreView
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteStoreView
		$I->comment("Exiting Action Group [deleteStoreView] AdminDeleteStoreViewActionGroup");
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
	 * @Stories({"Url rewrites"})
	 * @Features({"CatalogUrlRewrite"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCategoryUrlRewriteDifferentStoreTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToCreatedSubCategory] NavigateToCreatedCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnCategoryPageNavigateToCreatedSubCategory
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCreatedSubCategory
		$I->click(".tree-actions a:last-child"); // stepKey: expandAllNavigateToCreatedSubCategory
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCreatedSubCategory
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('subCategory', 'Name', 'test') . "')]"); // stepKey: navigateToCreatedCategoryNavigateToCreatedSubCategory
		$I->waitForPageLoad(30); // stepKey: navigateToCreatedCategoryNavigateToCreatedSubCategoryWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSpinnerNavigateToCreatedSubCategory
		$I->comment("Exiting Action Group [navigateToCreatedSubCategory] NavigateToCreatedCategoryActionGroup");
		$I->comment("Entering Action Group [AdminSwitchCustomStoreViewForSubCategory] AdminSwitchStoreViewActionGroup");
		$I->click("#store-change-button"); // stepKey: clickStoreViewSwitchDropdownAdminSwitchCustomStoreViewForSubCategory
		$I->waitForElementVisible("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'Default Store View')]", 30); // stepKey: waitForStoreViewsAreVisibleAdminSwitchCustomStoreViewForSubCategory
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewsAreVisibleAdminSwitchCustomStoreViewForSubCategoryWaitForPageLoad
		$I->click("//*[contains(@class,'store-switcher-store-view')]/*[contains(text(), 'FR" . msq("customStoreFR") . "')]"); // stepKey: clickStoreViewByNameAdminSwitchCustomStoreViewForSubCategory
		$I->waitForPageLoad(30); // stepKey: clickStoreViewByNameAdminSwitchCustomStoreViewForSubCategoryWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitingForInformationModalAdminSwitchCustomStoreViewForSubCategory
		$I->waitForPageLoad(60); // stepKey: waitingForInformationModalAdminSwitchCustomStoreViewForSubCategoryWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreSwitchAdminSwitchCustomStoreViewForSubCategory
		$I->waitForPageLoad(60); // stepKey: confirmStoreSwitchAdminSwitchCustomStoreViewForSubCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewSwitchedAdminSwitchCustomStoreViewForSubCategory
		$I->scrollToTopOfPage(); // stepKey: scrollToStoreSwitcherAdminSwitchCustomStoreViewForSubCategory
		$I->see("FR" . msq("customStoreFR"), ".store-switcher"); // stepKey: seeNewStoreViewNameAdminSwitchCustomStoreViewForSubCategory
		$I->comment("Exiting Action Group [AdminSwitchCustomStoreViewForSubCategory] AdminSwitchStoreViewActionGroup");
		$I->comment("Entering Action Group [changeSeoUrlKeyForSubCategoryCustomStore] ChangeSeoUrlKeyForSubCategoryActionGroup");
		$I->conditionalClick("div[data-index='search_engine_optimization'] .fieldset-wrapper-title", "div[data-index='search_engine_optimization'] .admin__fieldset-wrapper-content", false); // stepKey: openSeoSectionChangeSeoUrlKeyForSubCategoryCustomStore
		$I->uncheckOption("input[name='use_default[url_key]']"); // stepKey: uncheckDefaultValueChangeSeoUrlKeyForSubCategoryCustomStore
		$I->fillField("input[name='url_key']", "custom-simplesubcategory" . msq("SimpleSubCategoryDifferentUrlStore")); // stepKey: enterURLKeyChangeSeoUrlKeyForSubCategoryCustomStore
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryChangeSeoUrlKeyForSubCategoryCustomStore
		$I->waitForPageLoad(30); // stepKey: saveCategoryChangeSeoUrlKeyForSubCategoryCustomStoreWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: assertSuccessMessageChangeSeoUrlKeyForSubCategoryCustomStore
		$I->comment("Exiting Action Group [changeSeoUrlKeyForSubCategoryCustomStore] ChangeSeoUrlKeyForSubCategoryActionGroup");
		$I->comment("Entering Action Group [goToCategoryC] StorefrontGoToSubCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendGoToCategoryC
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToCategoryC
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('rootCategory', 'name', 'test') . "')]]"); // stepKey: toCategoryGoToCategoryC
		$I->waitForPageLoad(30); // stepKey: toCategoryGoToCategoryCWaitForPageLoad
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('subCategory', 'name', 'test') . "')]]"); // stepKey: openSubCategoryGoToCategoryC
		$I->waitForPageLoad(30); // stepKey: openSubCategoryGoToCategoryCWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageGoToCategoryC
		$I->comment("Exiting Action Group [goToCategoryC] StorefrontGoToSubCategoryPageActionGroup");
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: navigateToCreateProduct
		$I->comment("Entering Action Group [switchStore] StorefrontSwitchStoreViewActionGroup");
		$I->click("#switcher-language-trigger"); // stepKey: clickStoreViewSwitcherSwitchStore
		$I->waitForElementVisible(".active ul.switcher-dropdown", 30); // stepKey: waitForStoreViewDropdownSwitchStore
		$I->click("li.view-fr" . msq("customStoreFR") . ">a"); // stepKey: clickSelectStoreViewSwitchStore
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchStore
		$I->comment("Exiting Action Group [switchStore] StorefrontSwitchStoreViewActionGroup");
		$grabUrl = $I->grabFromCurrentUrl(); // stepKey: grabUrl
		$I->assertStringContainsString("custom-simplesubcategory" . msq("SimpleSubCategoryDifferentUrlStore"), $grabUrl); // stepKey: assertUrl
	}
}
