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
 * @Title("MC-32112: Recently Viewed Product at store view level")
 * @Description("Recently Viewed Product should not be displayed on second store view, if configured as, Per Store View<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/StoreFrontRecentlyViewedAtStoreViewLevelTest.xml<br>")
 * @TestCaseId("MC-32112")
 * @group catalog
 * @group WYSIWYGDisabled
 */
class StoreFrontRecentlyViewedAtStoreViewLevelTestCest
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
		$I->comment("Create storeView 1");
		$I->comment("Entering Action Group [createStoreViewOne] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreViewOne
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreViewOne
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateStoreViewOne
		$I->fillField("#store_name", "EN" . msq("customStoreEN")); // stepKey: enterStoreViewNameCreateStoreViewOne
		$I->fillField("#store_code", "en" . msq("customStoreEN")); // stepKey: enterStoreViewCodeCreateStoreViewOne
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateStoreViewOne
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateStoreViewOne
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateStoreViewOneWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateStoreViewOne
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateStoreViewOneWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateStoreViewOne
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateStoreViewOne
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateStoreViewOneWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateStoreViewOne
		$I->comment("Exiting Action Group [createStoreViewOne] AdminCreateStoreViewActionGroup");
		$runCronIndex = $I->magentoCron("index", 90); // stepKey: runCronIndex
		$I->comment($runCronIndex);
		$I->comment("Set Stores > Configurations > Catalog > Recently Viewed/Compared Products > Show for Current = store view");
		$RecentlyViewedProductScopeStore = $I->magentoCLI("config:set catalog/recently_products/scope store", 60); // stepKey: RecentlyViewedProductScopeStore
		$I->comment($RecentlyViewedProductScopeStore);
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
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadWebSite
		$RecentlyViewedProductScopeWebsite = $I->magentoCLI("config:set catalog/recently_products/scope website", 60); // stepKey: RecentlyViewedProductScopeWebsite
		$I->comment($RecentlyViewedProductScopeWebsite);
		$I->comment("Delete store views");
		$I->comment("Entering Action Group [deleteFirstStoreView] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteFirstStoreView
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteFirstStoreView
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteFirstStoreView
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteFirstStoreViewWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "EN" . msq("customStoreEN")); // stepKey: fillStoreViewFilterFieldDeleteFirstStoreView
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteFirstStoreViewWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteFirstStoreView
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteFirstStoreViewWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteFirstStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteFirstStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteFirstStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteFirstStoreViewWaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteFirstStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteFirstStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteFirstStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteFirstStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteFirstStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteFirstStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteFirstStoreView
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteFirstStoreView
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteFirstStoreView
		$I->comment("Exiting Action Group [deleteFirstStoreView] AdminDeleteStoreViewActionGroup");
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
	public function StoreFrontRecentlyViewedAtStoreViewLevelTest(AcceptanceTester $I)
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
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page/edit/page_id/2"); // stepKey: navigateToEditHomePagePage
		$I->waitForPageLoad(50); // stepKey: waitForContentPageToLoad
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
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToStore1ProductPage2
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct3', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToStore1ProductPage3
		$I->comment("Go to Home Page");
		$I->comment("Entering Action Group [amOnHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageAmOnHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadAmOnHomePage
		$I->comment("Exiting Action Group [amOnHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [assertStore1RecentlyViewedProduct2] AssertSeeProductDetailsOnStorefrontRecentlyViewedWidgetActionGroup");
		$grabRelatedProductPositionAssertStore1RecentlyViewedProduct2 = $I->grabTextFrom("//div[@class='products-grid']/ol/li[position()=2]/div/div[@class='product-item-details']/strong/a"); // stepKey: grabRelatedProductPositionAssertStore1RecentlyViewedProduct2
		$I->assertStringContainsString($I->retrieveEntityField('createSimpleProduct2', 'name', 'test'), $grabRelatedProductPositionAssertStore1RecentlyViewedProduct2); // stepKey: assertRelatedProductNameAssertStore1RecentlyViewedProduct2
		$I->comment("Exiting Action Group [assertStore1RecentlyViewedProduct2] AssertSeeProductDetailsOnStorefrontRecentlyViewedWidgetActionGroup");
		$I->comment("Entering Action Group [assertStore1RecentlyViewedProduct3] AssertSeeProductDetailsOnStorefrontRecentlyViewedWidgetActionGroup");
		$grabRelatedProductPositionAssertStore1RecentlyViewedProduct3 = $I->grabTextFrom("//div[@class='products-grid']/ol/li[position()=1]/div/div[@class='product-item-details']/strong/a"); // stepKey: grabRelatedProductPositionAssertStore1RecentlyViewedProduct3
		$I->assertStringContainsString($I->retrieveEntityField('createSimpleProduct3', 'name', 'test'), $grabRelatedProductPositionAssertStore1RecentlyViewedProduct3); // stepKey: assertRelatedProductNameAssertStore1RecentlyViewedProduct3
		$I->comment("Exiting Action Group [assertStore1RecentlyViewedProduct3] AssertSeeProductDetailsOnStorefrontRecentlyViewedWidgetActionGroup");
		$I->comment("Switch store view");
		$I->waitForPageLoad(40); // stepKey: waitForStorefrontPageLoad
		$I->comment("Entering Action Group [switchStoreViewActionGroup] StorefrontSwitchStoreViewActionGroup");
		$I->click("#switcher-language-trigger"); // stepKey: clickStoreViewSwitcherSwitchStoreViewActionGroup
		$I->waitForElementVisible(".active ul.switcher-dropdown", 30); // stepKey: waitForStoreViewDropdownSwitchStoreViewActionGroup
		$I->click("li.view-en" . msq("customStoreEN") . ">a"); // stepKey: clickSelectStoreViewSwitchStoreViewActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchStoreViewActionGroup
		$I->comment("Exiting Action Group [switchStoreViewActionGroup] StorefrontSwitchStoreViewActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToStore2ProductPage1
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToStore2ProductPage2
		$I->comment("Go to Home Page");
		$I->comment("Entering Action Group [amOnStoreViewHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageAmOnStoreViewHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadAmOnStoreViewHomePage
		$I->comment("Exiting Action Group [amOnStoreViewHomePage] StorefrontOpenHomePageActionGroup");
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
		$I->comment("Entering Action Group [switchToDefualtStoreView] StorefrontSwitchDefaultStoreViewActionGroup");
		$I->click("#switcher-language-trigger"); // stepKey: clickStoreViewSwitcherSwitchToDefualtStoreView
		$I->waitForElementVisible(".active ul.switcher-dropdown", 30); // stepKey: waitForStoreViewDropdownSwitchToDefualtStoreView
		$I->click("li.view-default>a"); // stepKey: clickSelectDefaultStoreViewSwitchToDefualtStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchToDefualtStoreView
		$I->comment("Exiting Action Group [switchToDefualtStoreView] StorefrontSwitchDefaultStoreViewActionGroup");
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
