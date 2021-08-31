<?php
namespace Magento\AcceptanceTest\_WYSIWYGDisabledSuite\Backend;

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
 * @Title("MC-32226: Recently Viewed Product at store level")
 * @Description("Recently Viewed Product should not be displayed on second store , if configured as, Per Store<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/StoreFrontRecentlyViewedAtStoreLevelTest.xml<br>")
 * @TestCaseId("MC-32226")
 * @group catalog
 * @group WYSIWYGDisabled
 */
class StoreFrontRecentlyViewedAtStoreLevelTestCest
{
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
		$I->comment("Create Simple Product and Category");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct1", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct1
		$I->createEntity("createSimpleProduct2", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct2
		$I->createEntity("createSimpleProduct3", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct3
		$I->createEntity("createSimpleProduct4", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct4
		$I->comment("Create store1 for default website");
		$I->comment("Entering Action Group [createFirstStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreViewCreateFirstStore
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateFirstStore
		$I->comment("Create Store group");
		$I->selectOption("#group_website_id", "Main Website"); // stepKey: selectWebsiteCreateFirstStore
		$I->fillField("#group_name", "store" . msq("customStore")); // stepKey: enterStoreGroupNameCreateFirstStore
		$I->fillField("#group_code", "store" . msq("customStore")); // stepKey: enterStoreGroupCodeCreateFirstStore
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: chooseRootCategoryCreateFirstStore
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateFirstStore
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateFirstStoreWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateFirstStore
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateFirstStore
		$I->comment("Exiting Action Group [createFirstStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Create Storeview1 for Store1");
		$I->comment("Entering Action Group [createStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "store" . msq("customStore")); // stepKey: selectStoreCreateStoreView
		$I->fillField("#store_name", "storeView" . msq("storeViewData")); // stepKey: enterStoreViewNameCreateStoreView
		$I->fillField("#store_code", "storeView" . msq("storeViewData")); // stepKey: enterStoreViewCodeCreateStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateStoreView
		$I->comment("Exiting Action Group [createStoreView] AdminCreateStoreViewActionGroup");
		$I->comment("Create storeView 2");
		$I->comment("Entering Action Group [createStoreViewTwo] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreViewTwo
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreViewTwo
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "store" . msq("customStore")); // stepKey: selectStoreCreateStoreViewTwo
		$I->fillField("#store_name", "EN" . msq("customStoreEN")); // stepKey: enterStoreViewNameCreateStoreViewTwo
		$I->fillField("#store_code", "en" . msq("customStoreEN")); // stepKey: enterStoreViewCodeCreateStoreViewTwo
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateStoreViewTwo
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateStoreViewTwo
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateStoreViewTwoWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateStoreViewTwo
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateStoreViewTwoWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateStoreViewTwo
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateStoreViewTwo
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateStoreViewTwoWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateStoreViewTwo
		$I->comment("Exiting Action Group [createStoreViewTwo] AdminCreateStoreViewActionGroup");
		$I->comment("Set Stores > Configurations > Catalog > Recently Viewed/Compared Products > Show for Current = store");
		$RecentlyViewedProductScopeStoreGroup = $I->magentoCLI("config:set catalog/recently_products/scope group", 60); // stepKey: RecentlyViewedProductScopeStoreGroup
		$I->comment($RecentlyViewedProductScopeStoreGroup);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete Product and Category");
		$I->deleteEntity("createSimpleProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("createSimpleProduct2", "hook"); // stepKey: deleteSimpleProduct2
		$I->deleteEntity("createSimpleProduct3", "hook"); // stepKey: deleteSimpleProduct3
		$I->deleteEntity("createSimpleProduct4", "hook"); // stepKey: deleteSimpleProduct4
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Delete store1 for default website");
		$I->comment("Entering Action Group [deleteFirstStore] DeleteCustomStoreActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteFirstStore
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteFirstStore
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteFirstStoreWaitForPageLoad
		$I->fillField("#storeGrid_filter_group_title", "store" . msq("customStore")); // stepKey: fillSearchStoreGroupFieldDeleteFirstStore
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteFirstStore
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteFirstStoreWaitForPageLoad
		$I->see("store" . msq("customStore"), ".col-group_title>a"); // stepKey: verifyThatCorrectStoreGroupFoundDeleteFirstStore
		$I->click(".col-group_title>a"); // stepKey: clickEditExistingStoreRowDeleteFirstStore
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteFirstStore
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteFirstStore
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnEditStorePageDeleteFirstStoreWaitForPageLoad
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteFirstStore
		$I->click("#delete"); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteFirstStore
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreGroupButtonOnDeleteStorePageDeleteFirstStoreWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteFirstStore
		$I->see("You deleted the store.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteFirstStore
		$I->comment("Exiting Action Group [deleteFirstStore] DeleteCustomStoreActionGroup");
		$I->comment("Reset Stores > Configurations > Catalog > Recently Viewed/Compared Products > Show for Current = Website");
		$RecentlyViewedProductScopeWebsite = $I->magentoCLI("config:set catalog/recently_products/scope website", 60); // stepKey: RecentlyViewedProductScopeWebsite
		$I->comment($RecentlyViewedProductScopeWebsite);
		$I->comment("Clear Widget");
		$I->comment("Entering Action Group [clearRecentlyViewedWidgetsFromCMSContent] AdminEditCMSPageContentActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page/edit/page_id/2"); // stepKey: navigateToEditCMSPageClearRecentlyViewedWidgetsFromCMSContent
		$I->waitForPageLoad(30); // stepKey: waitForCmsPageEditPageClearRecentlyViewedWidgetsFromCMSContent
		$I->conditionalClick("div[data-index=content]", "input[name=content_heading]", false); // stepKey: expandContentTabClearRecentlyViewedWidgetsFromCMSContent
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadContentSectionClearRecentlyViewedWidgetsFromCMSContent
		$I->conditionalClick("//*[@id='togglecms_page_form_content']", ".scalable.action-add-widget.plugin", false); // stepKey: clickNextShowHideEditorIfVisibleClearRecentlyViewedWidgetsFromCMSContent
		$I->waitForElementVisible("#cms_page_form_content", 30); // stepKey: waitForContentFieldClearRecentlyViewedWidgetsFromCMSContent
		$I->fillField("#cms_page_form_content", "CMS homepage content goes here"); // stepKey: resetCMSPageToDefaultContentClearRecentlyViewedWidgetsFromCMSContent
		$I->click("#save-button"); // stepKey: clickSaveClearRecentlyViewedWidgetsFromCMSContent
		$I->waitForPageLoad(10); // stepKey: clickSaveClearRecentlyViewedWidgetsFromCMSContentWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSettingsApplyClearRecentlyViewedWidgetsFromCMSContent
		$I->comment("Exiting Action Group [clearRecentlyViewedWidgetsFromCMSContent] AdminEditCMSPageContentActionGroup");
		$I->comment("Logout Admin");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
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
	 * @Stories({"Recently Viewed Product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StoreFrontRecentlyViewedAtStoreLevelTest(AcceptanceTester $I)
	{
		$I->comment("Create widget for recently viewed products");
		$I->comment("Entering Action Group [clearRecentlyViewedWidgetsFromCMSContentBefore] AdminEditCMSPageContentActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page/edit/page_id/2"); // stepKey: navigateToEditCMSPageClearRecentlyViewedWidgetsFromCMSContentBefore
		$I->waitForPageLoad(30); // stepKey: waitForCmsPageEditPageClearRecentlyViewedWidgetsFromCMSContentBefore
		$I->conditionalClick("div[data-index=content]", "input[name=content_heading]", false); // stepKey: expandContentTabClearRecentlyViewedWidgetsFromCMSContentBefore
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadContentSectionClearRecentlyViewedWidgetsFromCMSContentBefore
		$I->conditionalClick("//*[@id='togglecms_page_form_content']", ".scalable.action-add-widget.plugin", false); // stepKey: clickNextShowHideEditorIfVisibleClearRecentlyViewedWidgetsFromCMSContentBefore
		$I->waitForElementVisible("#cms_page_form_content", 30); // stepKey: waitForContentFieldClearRecentlyViewedWidgetsFromCMSContentBefore
		$I->fillField("#cms_page_form_content", "CMS homepage content goes here"); // stepKey: resetCMSPageToDefaultContentClearRecentlyViewedWidgetsFromCMSContentBefore
		$I->click("#save-button"); // stepKey: clickSaveClearRecentlyViewedWidgetsFromCMSContentBefore
		$I->waitForPageLoad(10); // stepKey: clickSaveClearRecentlyViewedWidgetsFromCMSContentBeforeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSettingsApplyClearRecentlyViewedWidgetsFromCMSContentBefore
		$I->comment("Exiting Action Group [clearRecentlyViewedWidgetsFromCMSContentBefore] AdminEditCMSPageContentActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page/edit/page_id/2"); // stepKey: navigateToEditCmsHomePage
		$I->waitForPageLoad(50); // stepKey: waitForCmsContentPageToLoad
		$I->comment("Entering Action Group [insertRecentlyViewedWidget] AdminInsertRecentlyViewedWidgetActionGroup");
		$I->conditionalClick("//div[@class='fieldset-wrapper-title']//span[.='Content']", "//*[@id='togglecms_page_form_content']", false); // stepKey: expandContentSectionIfNotVisibleInsertRecentlyViewedWidget
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadContentSectionInsertRecentlyViewedWidget
		$I->conditionalClick("//*[@id='togglecms_page_form_content']", ".scalable.action-add-widget.plugin", false); // stepKey: clickNextShowHideEditorIfVisibleInsertRecentlyViewedWidget
		$I->waitForElementVisible(".scalable.action-add-widget.plugin", 30); // stepKey: waitForInsertWidgetElementInsertRecentlyViewedWidget
		$I->click(".scalable.action-add-widget.plugin"); // stepKey: clickInsertWidgetInsertRecentlyViewedWidget
		$I->waitForElementVisible("#select_widget_type", 30); // stepKey: waitForWidgetTypeDropDownVisibleInsertRecentlyViewedWidget
		$I->comment("Select \"Widget Type\"");
		$I->selectOption("#select_widget_type", "Recently Viewed Products"); // stepKey: selectRecentlyViewedProductsInsertRecentlyViewedWidget
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadWidgetTypeInsertRecentlyViewedWidget
		$I->comment("Select all product attributes");
		$I->dragAndDrop("select[name='parameters[show_attributes][]'] option:nth-of-type(1)", "select[name='parameters[show_attributes][]'] option:nth-of-type(4)"); // stepKey: selectProductSpecifiedOptionsInsertRecentlyViewedWidget
		$I->comment("Select all buttons to show");
		$I->dragAndDrop("select[name='parameters[show_buttons][]'] option:nth-of-type(3)", "select[name='parameters[show_buttons][]'] option:nth-of-type(3)"); // stepKey: selectButtonSpecifiedOptionsInsertRecentlyViewedWidget
		$I->click("#insert_button"); // stepKey: clickInsertWidgetToSaveInsertRecentlyViewedWidget
		$I->waitForPageLoad(30); // stepKey: clickInsertWidgetToSaveInsertRecentlyViewedWidgetWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForWidgetInsertPageLoadInsertRecentlyViewedWidget
		$I->comment("Check that widget is inserted");
		$I->waitForElementVisible("#cms_page_form_content", 30); // stepKey: checkCMSContentInsertRecentlyViewedWidget
		$I->click("#save-button"); // stepKey: clickNextSaveInsertRecentlyViewedWidget
		$I->waitForPageLoad(10); // stepKey: clickNextSaveInsertRecentlyViewedWidgetWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageActionSaveInsertRecentlyViewedWidget
		$I->waitForElementVisible("*[data-ui-id='messages-message-success']", 60); // stepKey: waitForSaveSuccessInsertRecentlyViewedWidget
		$I->comment("Exiting Action Group [insertRecentlyViewedWidget] AdminInsertRecentlyViewedWidgetActionGroup");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Navigate to product 3 on store front");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToStoreOneProductPageTwo
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct3', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToStoreOneProductPageThree
		$I->comment("Go to Home Page");
		$I->comment("Entering Action Group [amOnStoreFrontHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageAmOnStoreFrontHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadAmOnStoreFrontHomePage
		$I->comment("Exiting Action Group [amOnStoreFrontHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [assertStoreOneRecentlyViewedProduct2] AssertSeeProductDetailsOnStorefrontRecentlyViewedWidgetActionGroup");
		$grabRelatedProductPositionAssertStoreOneRecentlyViewedProduct2 = $I->grabTextFrom("//div[@class='products-grid']/ol/li[position()=2]/div/div[@class='product-item-details']/strong/a"); // stepKey: grabRelatedProductPositionAssertStoreOneRecentlyViewedProduct2
		$I->assertStringContainsString($I->retrieveEntityField('createSimpleProduct2', 'name', 'test'), $grabRelatedProductPositionAssertStoreOneRecentlyViewedProduct2); // stepKey: assertRelatedProductNameAssertStoreOneRecentlyViewedProduct2
		$I->comment("Exiting Action Group [assertStoreOneRecentlyViewedProduct2] AssertSeeProductDetailsOnStorefrontRecentlyViewedWidgetActionGroup");
		$I->comment("Entering Action Group [assertStoreOneRecentlyViewedProduct3] AssertSeeProductDetailsOnStorefrontRecentlyViewedWidgetActionGroup");
		$grabRelatedProductPositionAssertStoreOneRecentlyViewedProduct3 = $I->grabTextFrom("//div[@class='products-grid']/ol/li[position()=1]/div/div[@class='product-item-details']/strong/a"); // stepKey: grabRelatedProductPositionAssertStoreOneRecentlyViewedProduct3
		$I->assertStringContainsString($I->retrieveEntityField('createSimpleProduct3', 'name', 'test'), $grabRelatedProductPositionAssertStoreOneRecentlyViewedProduct3); // stepKey: assertRelatedProductNameAssertStoreOneRecentlyViewedProduct3
		$I->comment("Exiting Action Group [assertStoreOneRecentlyViewedProduct3] AssertSeeProductDetailsOnStorefrontRecentlyViewedWidgetActionGroup");
		$I->comment("Switch to second store and add second product (visible on second store) to wishlist");
		$I->click("#switcher-store-trigger"); // stepKey: clickSwitchStoreButtonOnDefaultStore
		$I->click("//ul[@class='dropdown switcher-dropdown']//a[contains(text(),'store" . msq("customStore") . "')]"); // stepKey: selectCustomStore
		$I->waitForPageLoad(30); // stepKey: selectCustomStoreWaitForPageLoad
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToStore2ProductPage1
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToStore2ProductPage2
		$I->comment("Go to Home Page");
		$I->comment("Entering Action Group [amOnHomePage2] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageAmOnHomePage2
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadAmOnHomePage2
		$I->comment("Exiting Action Group [amOnHomePage2] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [assertNextStore1RecentlyViewedProduct1] AssertSeeProductDetailsOnStorefrontRecentlyViewedWidgetActionGroup");
		$grabRelatedProductPositionAssertNextStore1RecentlyViewedProduct1 = $I->grabTextFrom("//div[@class='products-grid']/ol/li[position()=2]/div/div[@class='product-item-details']/strong/a"); // stepKey: grabRelatedProductPositionAssertNextStore1RecentlyViewedProduct1
		$I->assertStringContainsString($I->retrieveEntityField('createSimpleProduct1', 'name', 'test'), $grabRelatedProductPositionAssertNextStore1RecentlyViewedProduct1); // stepKey: assertRelatedProductNameAssertNextStore1RecentlyViewedProduct1
		$I->comment("Exiting Action Group [assertNextStore1RecentlyViewedProduct1] AssertSeeProductDetailsOnStorefrontRecentlyViewedWidgetActionGroup");
		$I->comment("Entering Action Group [assertNextStore1RecentlyViewedProduct2] AssertSeeProductDetailsOnStorefrontRecentlyViewedWidgetActionGroup");
		$grabRelatedProductPositionAssertNextStore1RecentlyViewedProduct2 = $I->grabTextFrom("//div[@class='products-grid']/ol/li[position()=1]/div/div[@class='product-item-details']/strong/a"); // stepKey: grabRelatedProductPositionAssertNextStore1RecentlyViewedProduct2
		$I->assertStringContainsString($I->retrieveEntityField('createSimpleProduct2', 'name', 'test'), $grabRelatedProductPositionAssertNextStore1RecentlyViewedProduct2); // stepKey: assertRelatedProductNameAssertNextStore1RecentlyViewedProduct2
		$I->comment("Exiting Action Group [assertNextStore1RecentlyViewedProduct2] AssertSeeProductDetailsOnStorefrontRecentlyViewedWidgetActionGroup");
		$grabDontSeeHomeProduct3 = $I->grabTextFrom("//div[@class='products-grid']/ol/li[position()=2]/div/div[@class='product-item-details']/strong/a"); // stepKey: grabDontSeeHomeProduct3
		$I->assertStringNotContainsString($I->retrieveEntityField('createSimpleProduct3', 'name', 'test'), $grabDontSeeHomeProduct3); // stepKey: assertNotSeeProduct3
		$I->comment("Switch Storeview");
		$I->comment("Entering Action Group [switchStoreViewActionGroup] StorefrontSwitchStoreViewActionGroup");
		$I->click("#switcher-language-trigger"); // stepKey: clickStoreViewSwitcherSwitchStoreViewActionGroup
		$I->waitForElementVisible(".active ul.switcher-dropdown", 30); // stepKey: waitForStoreViewDropdownSwitchStoreViewActionGroup
		$I->click("li.view-en" . msq("customStoreEN") . ">a"); // stepKey: clickSelectStoreViewSwitchStoreViewActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchStoreViewActionGroup
		$I->comment("Exiting Action Group [switchStoreViewActionGroup] StorefrontSwitchStoreViewActionGroup");
		$I->comment("Entering Action Group [assertNextStoreView2RecentlyViewedProduct1] AssertSeeProductDetailsOnStorefrontRecentlyViewedWidgetActionGroup");
		$grabRelatedProductPositionAssertNextStoreView2RecentlyViewedProduct1 = $I->grabTextFrom("//div[@class='products-grid']/ol/li[position()=2]/div/div[@class='product-item-details']/strong/a"); // stepKey: grabRelatedProductPositionAssertNextStoreView2RecentlyViewedProduct1
		$I->assertStringContainsString($I->retrieveEntityField('createSimpleProduct1', 'name', 'test'), $grabRelatedProductPositionAssertNextStoreView2RecentlyViewedProduct1); // stepKey: assertRelatedProductNameAssertNextStoreView2RecentlyViewedProduct1
		$I->comment("Exiting Action Group [assertNextStoreView2RecentlyViewedProduct1] AssertSeeProductDetailsOnStorefrontRecentlyViewedWidgetActionGroup");
		$I->comment("Entering Action Group [assertNextStoreView2RecentlyViewedProduct2] AssertSeeProductDetailsOnStorefrontRecentlyViewedWidgetActionGroup");
		$grabRelatedProductPositionAssertNextStoreView2RecentlyViewedProduct2 = $I->grabTextFrom("//div[@class='products-grid']/ol/li[position()=1]/div/div[@class='product-item-details']/strong/a"); // stepKey: grabRelatedProductPositionAssertNextStoreView2RecentlyViewedProduct2
		$I->assertStringContainsString($I->retrieveEntityField('createSimpleProduct2', 'name', 'test'), $grabRelatedProductPositionAssertNextStoreView2RecentlyViewedProduct2); // stepKey: assertRelatedProductNameAssertNextStoreView2RecentlyViewedProduct2
		$I->comment("Exiting Action Group [assertNextStoreView2RecentlyViewedProduct2] AssertSeeProductDetailsOnStorefrontRecentlyViewedWidgetActionGroup");
		$grabStoreView2DontSeeHomeProduct3 = $I->grabTextFrom("//div[@class='products-grid']/ol/li[position()=2]/div/div[@class='product-item-details']/strong/a"); // stepKey: grabStoreView2DontSeeHomeProduct3
		$I->assertStringNotContainsString($I->retrieveEntityField('createSimpleProduct3', 'name', 'test'), $grabDontSeeHomeProduct3); // stepKey: assertStoreView2NotSeeProduct3
		$I->comment("Switch to default store");
		$I->click("#switcher-store-trigger"); // stepKey: clickSwitchStoreButtonOnHomeDefaultStore
		$I->click("//ul[@class='dropdown switcher-dropdown']//a[contains(text(),'Main Website Store')]"); // stepKey: selectDefaultStoreToSwitchOn
		$I->waitForPageLoad(30); // stepKey: selectDefaultStoreToSwitchOnWaitForPageLoad
		$I->comment("Entering Action Group [assertSwitchStore1RecentlyViewedProduct2] AssertSeeProductDetailsOnStorefrontRecentlyViewedWidgetActionGroup");
		$grabRelatedProductPositionAssertSwitchStore1RecentlyViewedProduct2 = $I->grabTextFrom("//div[@class='products-grid']/ol/li[position()=2]/div/div[@class='product-item-details']/strong/a"); // stepKey: grabRelatedProductPositionAssertSwitchStore1RecentlyViewedProduct2
		$I->assertStringContainsString($I->retrieveEntityField('createSimpleProduct2', 'name', 'test'), $grabRelatedProductPositionAssertSwitchStore1RecentlyViewedProduct2); // stepKey: assertRelatedProductNameAssertSwitchStore1RecentlyViewedProduct2
		$I->comment("Exiting Action Group [assertSwitchStore1RecentlyViewedProduct2] AssertSeeProductDetailsOnStorefrontRecentlyViewedWidgetActionGroup");
		$I->comment("Entering Action Group [assertSwitchStore1RecentlyViewedProduct3] AssertSeeProductDetailsOnStorefrontRecentlyViewedWidgetActionGroup");
		$grabRelatedProductPositionAssertSwitchStore1RecentlyViewedProduct3 = $I->grabTextFrom("//div[@class='products-grid']/ol/li[position()=1]/div/div[@class='product-item-details']/strong/a"); // stepKey: grabRelatedProductPositionAssertSwitchStore1RecentlyViewedProduct3
		$I->assertStringContainsString($I->retrieveEntityField('createSimpleProduct3', 'name', 'test'), $grabRelatedProductPositionAssertSwitchStore1RecentlyViewedProduct3); // stepKey: assertRelatedProductNameAssertSwitchStore1RecentlyViewedProduct3
		$I->comment("Exiting Action Group [assertSwitchStore1RecentlyViewedProduct3] AssertSeeProductDetailsOnStorefrontRecentlyViewedWidgetActionGroup");
		$grabDontSeeHomeProduct1 = $I->grabTextFrom("//div[@class='products-grid']/ol/li[position()=2]/div/div[@class='product-item-details']/strong/a"); // stepKey: grabDontSeeHomeProduct1
		$I->assertStringNotContainsString($I->retrieveEntityField('createSimpleProduct1', 'name', 'test'), $grabDontSeeHomeProduct1); // stepKey: assertNotSeeProduct1
	}
}
