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
 * @Title("MAGETWO-94479: Checking operator more/less in the 'catalog Products List' widget")
 * @Description("Check 'less than', 'equals or greater than', 'equals or less than' operators<h3>Test files</h3>app/code/Magento/CatalogWidget/Test/Mftf/Test/CatalogProductListWidgetOperatorsTest.xml<br>")
 * @TestCaseId("MAGETWO-94479")
 * @group CatalogWidget
 * @group WYSIWYGDisabled
 */
class CatalogProductListWidgetOperatorsTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("simplecategory", "hook", "SimpleSubCategory", [], []); // stepKey: simplecategory
		$createFirstProductFields['price'] = "10";
		$I->createEntity("createFirstProduct", "hook", "SimpleProduct", ["simplecategory"], $createFirstProductFields); // stepKey: createFirstProduct
		$createSecondProductFields['price'] = "50";
		$I->createEntity("createSecondProduct", "hook", "SimpleProduct", ["simplecategory"], $createSecondProductFields); // stepKey: createSecondProduct
		$createThirdProductFields['price'] = "100";
		$I->createEntity("createThirdProduct", "hook", "SimpleProduct", ["simplecategory"], $createThirdProductFields); // stepKey: createThirdProduct
		$I->createEntity("createPreReqBlock", "hook", "_defaultBlock", [], []); // stepKey: createPreReqBlock
		$I->comment("User log in on back-end as admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [enableWYSIWYG] EnabledWYSIWYGActionGroup");
		$enableWYSIWYGEnableWYSIWYG = $I->magentoCLI("config:set cms/wysiwyg/enabled enabled", 60); // stepKey: enableWYSIWYGEnableWYSIWYG
		$I->comment($enableWYSIWYGEnableWYSIWYG);
		$I->comment("Exiting Action Group [enableWYSIWYG] EnabledWYSIWYGActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [disableWYSIWYG] DisabledWYSIWYGActionGroup");
		$disableWYSIWYGDisableWYSIWYG = $I->magentoCLI("config:set cms/wysiwyg/enabled disabled", 60); // stepKey: disableWYSIWYGDisableWYSIWYG
		$I->comment($disableWYSIWYGDisableWYSIWYG);
		$I->comment("Exiting Action Group [disableWYSIWYG] DisabledWYSIWYGActionGroup");
		$I->deleteEntity("createPreReqBlock", "hook"); // stepKey: deletePreReqBlock
		$I->deleteEntity("simplecategory", "hook"); // stepKey: deleteSimpleCategory
		$I->deleteEntity("createFirstProduct", "hook"); // stepKey: deleteFirstProduct
		$I->deleteEntity("createSecondProduct", "hook"); // stepKey: deleteSecondProduct
		$I->deleteEntity("createThirdProduct", "hook"); // stepKey: deleteThirdProduct
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
	 * @Features({"CatalogWidget"})
	 * @Stories({"MAGETWO-91609: Problems with operator more/less in the 'catalog Products List' widget"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function CatalogProductListWidgetOperatorsTest(AcceptanceTester $I)
	{
		$I->comment("Open block with widget.");
		$I->comment("Entering Action Group [navigateToCreatedCMSBlockPage1] NavigateToCreatedCMSBlockPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/block/"); // stepKey: navigateToCMSBlocksGridNavigateToCreatedCMSBlockPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCreatedCMSBlockPage1
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilterNavigateToCreatedCMSBlockPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCreatedCMSBlockPage1
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: clickToAttemptSortByIdDescendingNavigateToCreatedCMSBlockPage1
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFirstIdSortDescendingToFinishNavigateToCreatedCMSBlockPage1
		$I->comment("Conditional Click again in case it goes from default state to ascending on first click");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: secondClickToAttemptSortByIdDescendingNavigateToCreatedCMSBlockPage1
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinishNavigateToCreatedCMSBlockPage1
		$I->click("//div[text()='" . $I->retrieveEntityField('createPreReqBlock', 'identifier', 'test') . "']//parent::td//following-sibling::td//button[text()='Select']"); // stepKey: clickSelectCreatedCMSBlockNavigateToCreatedCMSBlockPage1
		$I->click("//div[text()='" . $I->retrieveEntityField('createPreReqBlock', 'identifier', 'test') . "']//parent::td//following-sibling::td//a[text()='Edit']"); // stepKey: navigateToCreatedCMSBlockNavigateToCreatedCMSBlockPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3NavigateToCreatedCMSBlockPage1
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOfStagingSectionNavigateToCreatedCMSBlockPage1
		$I->comment("Exiting Action Group [navigateToCreatedCMSBlockPage1] NavigateToCreatedCMSBlockPageActionGroup");
		$I->comment("Entering Action Group [adminCreateBlockWithWidget] AdminCreateBlockWithWidget");
		$I->click(".scalable.action-show-hide"); // stepKey: clickShowHideButtonAdminCreateBlockWithWidget
		$I->waitForElementVisible(".scalable.action-add-widget.plugin", 30); // stepKey: waitForInsertWidgetButtonAdminCreateBlockWithWidget
		$I->selectOption("//*[@name='store_id']", "All Store Views"); // stepKey: selectAllStoreViewAdminCreateBlockWithWidget
		$I->fillField("textarea", ""); // stepKey: makeContentFieldEmptyAdminCreateBlockWithWidget
		$I->click(".scalable.action-add-widget.plugin"); // stepKey: clickInsertWidgetButtonAdminCreateBlockWithWidget
		$I->waitForElementVisible("#select_widget_type", 10); // stepKey: waitForInsertWidgetFrameAdminCreateBlockWithWidget
		$I->selectOption("#select_widget_type", "Catalog Products List"); // stepKey: selectCatalogProductListOptionAdminCreateBlockWithWidget
		$I->waitForElementVisible(".rule-param.rule-param-new-child", 30); // stepKey: waitForConditionsElementBecomeAvailableAdminCreateBlockWithWidget
		$I->click(".rule-param.rule-param-new-child"); // stepKey: clickToAddConditionAdminCreateBlockWithWidget
		$I->waitForElementVisible("#conditions__1__new_child", 30); // stepKey: waitForSelectBoxOpenedAdminCreateBlockWithWidget
		$I->selectOption("#conditions__1__new_child", "Price"); // stepKey: selectConditionsSelectBoxAdminCreateBlockWithWidget
		$I->waitForElementVisible("//*[@id='conditions__1--1__value']/../preceding-sibling::a", 30); // stepKey: seeConditionsAddedAdminCreateBlockWithWidget
		$I->click("//*[@id='conditions__1--1__attribute']/following-sibling::span[1]"); // stepKey: clickToConditionIsAdminCreateBlockWithWidget
		$I->selectOption("#conditions__1--1__operator", "greater than"); // stepKey: selectOperatorGreaterThanAdminCreateBlockWithWidget
		$I->click("//*[@id='conditions__1--1__value']/../preceding-sibling::a"); // stepKey: clickAddConditionItemAdminCreateBlockWithWidget
		$I->waitForElementVisible("#conditions__1--1__value", 30); // stepKey: waitForConditionFieldOpenedAdminCreateBlockWithWidget
		$I->fillField("#conditions__1--1__value", "20"); // stepKey: setOperatorAdminCreateBlockWithWidget
		$I->click("#insert_button"); // stepKey: clickInsertWidgetAdminCreateBlockWithWidget
		$I->waitForPageLoad(30); // stepKey: clickInsertWidgetAdminCreateBlockWithWidgetWaitForPageLoad
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForInsertWidgetSavedAdminCreateBlockWithWidget
		$I->click("#save-button"); // stepKey: clickSaveButtonAdminCreateBlockWithWidget
		$I->see("You saved the block."); // stepKey: seeSavedBlockMsgOnFormAdminCreateBlockWithWidget
		$I->comment("Exiting Action Group [adminCreateBlockWithWidget] AdminCreateBlockWithWidget");
		$I->comment("Go to Catalog > Categories (choose category where created products)");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: onCategoryIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadAddProducts
		$I->click(".tree-actions a:last-child"); // stepKey: clickExpandAll
		$I->click("//a/span[contains(text(), 'SimpleSubCategory" . msq("SimpleSubCategory") . "')]"); // stepKey: clickCategoryLink
		$I->waitForPageLoad(30); // stepKey: clickCategoryLinkWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoad
		$I->comment("Content > Add CMS Block: name saved block");
		$I->waitForElementVisible("div[data-index='content']", 30); // stepKey: waitForContentSection
		$I->waitForPageLoad(30); // stepKey: waitForContentSectionWaitForPageLoad
		$I->conditionalClick("div[data-index='content']", "//*[@class='file-uploader-area']/label[text()='Upload']", false); // stepKey: openContentSection
		$I->waitForPageLoad(30); // stepKey: waitForContentLoad
		$I->selectOption("//*[@name='landing_page']", "Default Block" . msq("_defaultBlock")); // stepKey: selectSavedBlock
		$I->comment("Display Settings > Display Mode: Static block only");
		$I->waitForElementVisible("//*[contains(text(),'Display Settings')]", 30); // stepKey: waitForDisplaySettingsSection
		$I->waitForPageLoad(30); // stepKey: waitForDisplaySettingsSectionWaitForPageLoad
		$I->conditionalClick("//*[contains(text(),'Display Settings')]", "//*[@name='display_mode']", false); // stepKey: openDisplaySettingsSection
		$I->waitForPageLoad(30); // stepKey: waitForDisplaySettingsLoad
		$I->selectOption("//*[@name='display_mode']", "Static block only"); // stepKey: selectStaticBlockOnlyOption
		$I->comment("Entering Action Group [saveCategoryWithProducts] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveCategoryWithProducts
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveCategoryWithProductsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveCategoryWithProducts
		$I->comment("Exiting Action Group [saveCategoryWithProducts] AdminSaveCategoryActionGroup");
		$I->comment("Entering Action Group [seeSuccessMessage] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForElementSeeSuccessMessage
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: seeSuccessMessageSeeSuccessMessage
		$I->comment("Exiting Action Group [seeSuccessMessage] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->comment("Go to Storefront > category");
		$I->amOnPage($I->retrieveEntityField('simplecategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToStorefrontCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoaded
		$I->comment("Check operators Greater than");
		$I->dontSeeElement("//*[@class='product-items widget-product-grid']//*[contains(text(),'$10.00')]"); // stepKey: dontSeeElementByPrice20
		$I->seeElement("//*[@class='product-items widget-product-grid']//*[contains(text(),'$50.00')]"); // stepKey: seeElementByPrice50
		$I->seeElement("//*[@class='product-items widget-product-grid']//*[contains(text(),'$100.00')]"); // stepKey: seeElementByPrice100
		$I->comment("Open block with widget.");
		$I->comment("Entering Action Group [navigateToCreatedCMSBlockPage2] NavigateToCreatedCMSBlockPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/block/"); // stepKey: navigateToCMSBlocksGridNavigateToCreatedCMSBlockPage2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCreatedCMSBlockPage2
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilterNavigateToCreatedCMSBlockPage2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCreatedCMSBlockPage2
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: clickToAttemptSortByIdDescendingNavigateToCreatedCMSBlockPage2
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFirstIdSortDescendingToFinishNavigateToCreatedCMSBlockPage2
		$I->comment("Conditional Click again in case it goes from default state to ascending on first click");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: secondClickToAttemptSortByIdDescendingNavigateToCreatedCMSBlockPage2
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinishNavigateToCreatedCMSBlockPage2
		$I->click("//div[text()='" . $I->retrieveEntityField('createPreReqBlock', 'identifier', 'test') . "']//parent::td//following-sibling::td//button[text()='Select']"); // stepKey: clickSelectCreatedCMSBlockNavigateToCreatedCMSBlockPage2
		$I->click("//div[text()='" . $I->retrieveEntityField('createPreReqBlock', 'identifier', 'test') . "']//parent::td//following-sibling::td//a[text()='Edit']"); // stepKey: navigateToCreatedCMSBlockNavigateToCreatedCMSBlockPage2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3NavigateToCreatedCMSBlockPage2
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOfStagingSectionNavigateToCreatedCMSBlockPage2
		$I->comment("Exiting Action Group [navigateToCreatedCMSBlockPage2] NavigateToCreatedCMSBlockPageActionGroup");
		$I->comment("Entering Action Group [adminCreateBlockWithWidgetLessThan] AdminCreateBlockWithWidget");
		$I->click(".scalable.action-show-hide"); // stepKey: clickShowHideButtonAdminCreateBlockWithWidgetLessThan
		$I->waitForElementVisible(".scalable.action-add-widget.plugin", 30); // stepKey: waitForInsertWidgetButtonAdminCreateBlockWithWidgetLessThan
		$I->selectOption("//*[@name='store_id']", "All Store Views"); // stepKey: selectAllStoreViewAdminCreateBlockWithWidgetLessThan
		$I->fillField("textarea", ""); // stepKey: makeContentFieldEmptyAdminCreateBlockWithWidgetLessThan
		$I->click(".scalable.action-add-widget.plugin"); // stepKey: clickInsertWidgetButtonAdminCreateBlockWithWidgetLessThan
		$I->waitForElementVisible("#select_widget_type", 10); // stepKey: waitForInsertWidgetFrameAdminCreateBlockWithWidgetLessThan
		$I->selectOption("#select_widget_type", "Catalog Products List"); // stepKey: selectCatalogProductListOptionAdminCreateBlockWithWidgetLessThan
		$I->waitForElementVisible(".rule-param.rule-param-new-child", 30); // stepKey: waitForConditionsElementBecomeAvailableAdminCreateBlockWithWidgetLessThan
		$I->click(".rule-param.rule-param-new-child"); // stepKey: clickToAddConditionAdminCreateBlockWithWidgetLessThan
		$I->waitForElementVisible("#conditions__1__new_child", 30); // stepKey: waitForSelectBoxOpenedAdminCreateBlockWithWidgetLessThan
		$I->selectOption("#conditions__1__new_child", "Price"); // stepKey: selectConditionsSelectBoxAdminCreateBlockWithWidgetLessThan
		$I->waitForElementVisible("//*[@id='conditions__1--1__value']/../preceding-sibling::a", 30); // stepKey: seeConditionsAddedAdminCreateBlockWithWidgetLessThan
		$I->click("//*[@id='conditions__1--1__attribute']/following-sibling::span[1]"); // stepKey: clickToConditionIsAdminCreateBlockWithWidgetLessThan
		$I->selectOption("#conditions__1--1__operator", "less than"); // stepKey: selectOperatorGreaterThanAdminCreateBlockWithWidgetLessThan
		$I->click("//*[@id='conditions__1--1__value']/../preceding-sibling::a"); // stepKey: clickAddConditionItemAdminCreateBlockWithWidgetLessThan
		$I->waitForElementVisible("#conditions__1--1__value", 30); // stepKey: waitForConditionFieldOpenedAdminCreateBlockWithWidgetLessThan
		$I->fillField("#conditions__1--1__value", "20"); // stepKey: setOperatorAdminCreateBlockWithWidgetLessThan
		$I->click("#insert_button"); // stepKey: clickInsertWidgetAdminCreateBlockWithWidgetLessThan
		$I->waitForPageLoad(30); // stepKey: clickInsertWidgetAdminCreateBlockWithWidgetLessThanWaitForPageLoad
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForInsertWidgetSavedAdminCreateBlockWithWidgetLessThan
		$I->click("#save-button"); // stepKey: clickSaveButtonAdminCreateBlockWithWidgetLessThan
		$I->see("You saved the block."); // stepKey: seeSavedBlockMsgOnFormAdminCreateBlockWithWidgetLessThan
		$I->comment("Exiting Action Group [adminCreateBlockWithWidgetLessThan] AdminCreateBlockWithWidget");
		$I->comment("Go to Storefront > category");
		$I->amOnPage($I->retrieveEntityField('simplecategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToStorefrontCategoryPage2
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoaded2
		$I->comment("Check operators Greater than");
		$I->seeElement("//*[@class='product-items widget-product-grid']//*[contains(text(),'$10.00')]"); // stepKey: seeElementByPrice20
		$I->dontSeeElement("//*[@class='product-items widget-product-grid']//*[contains(text(),'$50.00')]"); // stepKey: dontSeeElementByPrice50
		$I->dontSeeElement("//*[@class='product-items widget-product-grid']//*[contains(text(),'$100.00')]"); // stepKey: dontSeeElementByPrice100
		$I->comment("Open block with widget.");
		$I->comment("Entering Action Group [navigateToCreatedCMSBlockPage3] NavigateToCreatedCMSBlockPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/block/"); // stepKey: navigateToCMSBlocksGridNavigateToCreatedCMSBlockPage3
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCreatedCMSBlockPage3
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilterNavigateToCreatedCMSBlockPage3
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCreatedCMSBlockPage3
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: clickToAttemptSortByIdDescendingNavigateToCreatedCMSBlockPage3
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFirstIdSortDescendingToFinishNavigateToCreatedCMSBlockPage3
		$I->comment("Conditional Click again in case it goes from default state to ascending on first click");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: secondClickToAttemptSortByIdDescendingNavigateToCreatedCMSBlockPage3
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinishNavigateToCreatedCMSBlockPage3
		$I->click("//div[text()='" . $I->retrieveEntityField('createPreReqBlock', 'identifier', 'test') . "']//parent::td//following-sibling::td//button[text()='Select']"); // stepKey: clickSelectCreatedCMSBlockNavigateToCreatedCMSBlockPage3
		$I->click("//div[text()='" . $I->retrieveEntityField('createPreReqBlock', 'identifier', 'test') . "']//parent::td//following-sibling::td//a[text()='Edit']"); // stepKey: navigateToCreatedCMSBlockNavigateToCreatedCMSBlockPage3
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3NavigateToCreatedCMSBlockPage3
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOfStagingSectionNavigateToCreatedCMSBlockPage3
		$I->comment("Exiting Action Group [navigateToCreatedCMSBlockPage3] NavigateToCreatedCMSBlockPageActionGroup");
		$I->comment("Entering Action Group [adminCreateBlockWithWidgetEqualsOrGreaterThan] AdminCreateBlockWithWidget");
		$I->click(".scalable.action-show-hide"); // stepKey: clickShowHideButtonAdminCreateBlockWithWidgetEqualsOrGreaterThan
		$I->waitForElementVisible(".scalable.action-add-widget.plugin", 30); // stepKey: waitForInsertWidgetButtonAdminCreateBlockWithWidgetEqualsOrGreaterThan
		$I->selectOption("//*[@name='store_id']", "All Store Views"); // stepKey: selectAllStoreViewAdminCreateBlockWithWidgetEqualsOrGreaterThan
		$I->fillField("textarea", ""); // stepKey: makeContentFieldEmptyAdminCreateBlockWithWidgetEqualsOrGreaterThan
		$I->click(".scalable.action-add-widget.plugin"); // stepKey: clickInsertWidgetButtonAdminCreateBlockWithWidgetEqualsOrGreaterThan
		$I->waitForElementVisible("#select_widget_type", 10); // stepKey: waitForInsertWidgetFrameAdminCreateBlockWithWidgetEqualsOrGreaterThan
		$I->selectOption("#select_widget_type", "Catalog Products List"); // stepKey: selectCatalogProductListOptionAdminCreateBlockWithWidgetEqualsOrGreaterThan
		$I->waitForElementVisible(".rule-param.rule-param-new-child", 30); // stepKey: waitForConditionsElementBecomeAvailableAdminCreateBlockWithWidgetEqualsOrGreaterThan
		$I->click(".rule-param.rule-param-new-child"); // stepKey: clickToAddConditionAdminCreateBlockWithWidgetEqualsOrGreaterThan
		$I->waitForElementVisible("#conditions__1__new_child", 30); // stepKey: waitForSelectBoxOpenedAdminCreateBlockWithWidgetEqualsOrGreaterThan
		$I->selectOption("#conditions__1__new_child", "Price"); // stepKey: selectConditionsSelectBoxAdminCreateBlockWithWidgetEqualsOrGreaterThan
		$I->waitForElementVisible("//*[@id='conditions__1--1__value']/../preceding-sibling::a", 30); // stepKey: seeConditionsAddedAdminCreateBlockWithWidgetEqualsOrGreaterThan
		$I->click("//*[@id='conditions__1--1__attribute']/following-sibling::span[1]"); // stepKey: clickToConditionIsAdminCreateBlockWithWidgetEqualsOrGreaterThan
		$I->selectOption("#conditions__1--1__operator", "equals or greater than"); // stepKey: selectOperatorGreaterThanAdminCreateBlockWithWidgetEqualsOrGreaterThan
		$I->click("//*[@id='conditions__1--1__value']/../preceding-sibling::a"); // stepKey: clickAddConditionItemAdminCreateBlockWithWidgetEqualsOrGreaterThan
		$I->waitForElementVisible("#conditions__1--1__value", 30); // stepKey: waitForConditionFieldOpenedAdminCreateBlockWithWidgetEqualsOrGreaterThan
		$I->fillField("#conditions__1--1__value", "50"); // stepKey: setOperatorAdminCreateBlockWithWidgetEqualsOrGreaterThan
		$I->click("#insert_button"); // stepKey: clickInsertWidgetAdminCreateBlockWithWidgetEqualsOrGreaterThan
		$I->waitForPageLoad(30); // stepKey: clickInsertWidgetAdminCreateBlockWithWidgetEqualsOrGreaterThanWaitForPageLoad
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForInsertWidgetSavedAdminCreateBlockWithWidgetEqualsOrGreaterThan
		$I->click("#save-button"); // stepKey: clickSaveButtonAdminCreateBlockWithWidgetEqualsOrGreaterThan
		$I->see("You saved the block."); // stepKey: seeSavedBlockMsgOnFormAdminCreateBlockWithWidgetEqualsOrGreaterThan
		$I->comment("Exiting Action Group [adminCreateBlockWithWidgetEqualsOrGreaterThan] AdminCreateBlockWithWidget");
		$I->comment("Go to Storefront > category");
		$I->amOnPage($I->retrieveEntityField('simplecategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToStorefrontCategoryPage3
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoaded3
		$I->comment("Check operators Greater than");
		$I->dontSeeElement("//*[@class='product-items widget-product-grid']//*[contains(text(),'$10.00')]"); // stepKey: dontSeeElementByPrice20s
		$I->seeElement("//*[@class='product-items widget-product-grid']//*[contains(text(),'$50.00')]"); // stepKey: seeElementByPrice50s
		$I->seeElement("//*[@class='product-items widget-product-grid']//*[contains(text(),'$100.00')]"); // stepKey: seeElementByPrice100s
		$I->comment("Open block with widget.");
		$I->comment("Entering Action Group [navigateToCreatedCMSBlockPage4] NavigateToCreatedCMSBlockPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/block/"); // stepKey: navigateToCMSBlocksGridNavigateToCreatedCMSBlockPage4
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCreatedCMSBlockPage4
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilterNavigateToCreatedCMSBlockPage4
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCreatedCMSBlockPage4
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: clickToAttemptSortByIdDescendingNavigateToCreatedCMSBlockPage4
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFirstIdSortDescendingToFinishNavigateToCreatedCMSBlockPage4
		$I->comment("Conditional Click again in case it goes from default state to ascending on first click");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: secondClickToAttemptSortByIdDescendingNavigateToCreatedCMSBlockPage4
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinishNavigateToCreatedCMSBlockPage4
		$I->click("//div[text()='" . $I->retrieveEntityField('createPreReqBlock', 'identifier', 'test') . "']//parent::td//following-sibling::td//button[text()='Select']"); // stepKey: clickSelectCreatedCMSBlockNavigateToCreatedCMSBlockPage4
		$I->click("//div[text()='" . $I->retrieveEntityField('createPreReqBlock', 'identifier', 'test') . "']//parent::td//following-sibling::td//a[text()='Edit']"); // stepKey: navigateToCreatedCMSBlockNavigateToCreatedCMSBlockPage4
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3NavigateToCreatedCMSBlockPage4
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOfStagingSectionNavigateToCreatedCMSBlockPage4
		$I->comment("Exiting Action Group [navigateToCreatedCMSBlockPage4] NavigateToCreatedCMSBlockPageActionGroup");
		$I->comment("Entering Action Group [adminCreateBlockWithWidgetEqualsOrLessThan] AdminCreateBlockWithWidget");
		$I->click(".scalable.action-show-hide"); // stepKey: clickShowHideButtonAdminCreateBlockWithWidgetEqualsOrLessThan
		$I->waitForElementVisible(".scalable.action-add-widget.plugin", 30); // stepKey: waitForInsertWidgetButtonAdminCreateBlockWithWidgetEqualsOrLessThan
		$I->selectOption("//*[@name='store_id']", "All Store Views"); // stepKey: selectAllStoreViewAdminCreateBlockWithWidgetEqualsOrLessThan
		$I->fillField("textarea", ""); // stepKey: makeContentFieldEmptyAdminCreateBlockWithWidgetEqualsOrLessThan
		$I->click(".scalable.action-add-widget.plugin"); // stepKey: clickInsertWidgetButtonAdminCreateBlockWithWidgetEqualsOrLessThan
		$I->waitForElementVisible("#select_widget_type", 10); // stepKey: waitForInsertWidgetFrameAdminCreateBlockWithWidgetEqualsOrLessThan
		$I->selectOption("#select_widget_type", "Catalog Products List"); // stepKey: selectCatalogProductListOptionAdminCreateBlockWithWidgetEqualsOrLessThan
		$I->waitForElementVisible(".rule-param.rule-param-new-child", 30); // stepKey: waitForConditionsElementBecomeAvailableAdminCreateBlockWithWidgetEqualsOrLessThan
		$I->click(".rule-param.rule-param-new-child"); // stepKey: clickToAddConditionAdminCreateBlockWithWidgetEqualsOrLessThan
		$I->waitForElementVisible("#conditions__1__new_child", 30); // stepKey: waitForSelectBoxOpenedAdminCreateBlockWithWidgetEqualsOrLessThan
		$I->selectOption("#conditions__1__new_child", "Price"); // stepKey: selectConditionsSelectBoxAdminCreateBlockWithWidgetEqualsOrLessThan
		$I->waitForElementVisible("//*[@id='conditions__1--1__value']/../preceding-sibling::a", 30); // stepKey: seeConditionsAddedAdminCreateBlockWithWidgetEqualsOrLessThan
		$I->click("//*[@id='conditions__1--1__attribute']/following-sibling::span[1]"); // stepKey: clickToConditionIsAdminCreateBlockWithWidgetEqualsOrLessThan
		$I->selectOption("#conditions__1--1__operator", "equals or less than"); // stepKey: selectOperatorGreaterThanAdminCreateBlockWithWidgetEqualsOrLessThan
		$I->click("//*[@id='conditions__1--1__value']/../preceding-sibling::a"); // stepKey: clickAddConditionItemAdminCreateBlockWithWidgetEqualsOrLessThan
		$I->waitForElementVisible("#conditions__1--1__value", 30); // stepKey: waitForConditionFieldOpenedAdminCreateBlockWithWidgetEqualsOrLessThan
		$I->fillField("#conditions__1--1__value", "50"); // stepKey: setOperatorAdminCreateBlockWithWidgetEqualsOrLessThan
		$I->click("#insert_button"); // stepKey: clickInsertWidgetAdminCreateBlockWithWidgetEqualsOrLessThan
		$I->waitForPageLoad(30); // stepKey: clickInsertWidgetAdminCreateBlockWithWidgetEqualsOrLessThanWaitForPageLoad
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForInsertWidgetSavedAdminCreateBlockWithWidgetEqualsOrLessThan
		$I->click("#save-button"); // stepKey: clickSaveButtonAdminCreateBlockWithWidgetEqualsOrLessThan
		$I->see("You saved the block."); // stepKey: seeSavedBlockMsgOnFormAdminCreateBlockWithWidgetEqualsOrLessThan
		$I->comment("Exiting Action Group [adminCreateBlockWithWidgetEqualsOrLessThan] AdminCreateBlockWithWidget");
		$I->comment("Go to Storefront > category");
		$I->amOnPage($I->retrieveEntityField('simplecategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToStorefrontCategoryPage4
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoaded4
		$I->comment("Check operators Greater than");
		$I->seeElement("//*[@class='product-items widget-product-grid']//*[contains(text(),'$10.00')]"); // stepKey: seeElementByPrice20s
		$I->seeElement("//*[@class='product-items widget-product-grid']//*[contains(text(),'$50.00')]"); // stepKey: seeElementByPrice50t
		$I->dontSeeElement("//*[@class='product-items widget-product-grid']//*[contains(text(),'$100.00')]"); // stepKey: dontSeeElementByPrice100s
	}
}
