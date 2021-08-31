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
 * @Title("MC-27616: Checking order of products in the 'catalog Products List' widget")
 * @Description("Check that products are ordered with recently added products first<h3>Test files</h3>app/code/Magento/CatalogWidget/Test/Mftf/Test/CatalogProductListCheckWidgetOrderTest.xml<br>")
 * @TestCaseId("MC-27616")
 * @group catalogWidget
 * @group catalog
 * @group WYSIWYGDisabled
 */
class CatalogProductListCheckWidgetOrderTestCest
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
		$createSecondProductFields['price'] = "20";
		$I->createEntity("createSecondProduct", "hook", "SimpleProduct", ["simplecategory"], $createSecondProductFields); // stepKey: createSecondProduct
		$createThirdProductFields['price'] = "30";
		$I->createEntity("createThirdProduct", "hook", "SimpleProduct", ["simplecategory"], $createThirdProductFields); // stepKey: createThirdProduct
		$I->createEntity("createPreReqPage", "hook", "_defaultCmsPage", [], []); // stepKey: createPreReqPage
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
		$I->deleteEntity("createPreReqPage", "hook"); // stepKey: deletePreReqPage
		$I->deleteEntity("simplecategory", "hook"); // stepKey: deleteSimpleCategory
		$I->deleteEntity("createFirstProduct", "hook"); // stepKey: deleteFirstProduct
		$I->deleteEntity("createSecondProduct", "hook"); // stepKey: deleteSecondProduct
		$I->deleteEntity("createThirdProduct", "hook"); // stepKey: deleteThirdProduct
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Stories({"Product list widget"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function CatalogProductListCheckWidgetOrderTest(AcceptanceTester $I)
	{
		$I->comment("Open created cms page");
		$I->comment("Entering Action Group [openEditPage] AdminOpenCmsPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page/edit/page_id/" . $I->retrieveEntityField('createPreReqPage', 'id', 'test')); // stepKey: openEditCmsPageOpenEditPage
		$I->comment("Exiting Action Group [openEditPage] AdminOpenCmsPageActionGroup");
		$I->click("div[data-index=content]"); // stepKey: clickExpandContentTabForPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMask
		$I->comment("Add widget to cms page");
		$I->waitForElementVisible("button[aria-label='Insert Widget']", 30); // stepKey: waitInsertWidgetIconVisible
		$I->waitForPageLoad(30); // stepKey: waitInsertWidgetIconVisibleWaitForPageLoad
		$I->click("button[aria-label='Insert Widget']"); // stepKey: clickInsertWidgetIcon
		$I->waitForPageLoad(30); // stepKey: clickInsertWidgetIconWaitForPageLoad
		$I->waitForElementVisible("#select_widget_type", 30); // stepKey: waitForWidgetTypeSelectorVisible
		$I->selectOption("#select_widget_type", "Catalog Products List"); // stepKey: selectCatalogProductsList
		$I->waitForElementVisible(".rule-param-add", 30); // stepKey: waitForAddParamBtnVisible
		$I->click(".rule-param-add"); // stepKey: clickAddParamBtn
		$I->waitForElementVisible("#conditions__1__new_child", 30); // stepKey: waitForDropdownVisible
		$I->selectOption("#conditions__1__new_child", "Category"); // stepKey: selectCategoryCondition
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskDisappear2
		$I->waitForElementVisible("//a[text()='...']", 30); // stepKey: waitForRuleParamVisible
		$I->click("//a[text()='...']"); // stepKey: clickRuleParam
		$I->waitForElementVisible("//img[@title='Open Chooser']", 30); // stepKey: waitForElement
		$I->click("//img[@title='Open Chooser']"); // stepKey: clickChooser
		$I->waitForElementVisible(" //span[contains(text(),'" . $I->retrieveEntityField('simplecategory', 'name', 'test') . "')]", 30); // stepKey: waitForCategoryVisible
		$I->click(" //span[contains(text(),'" . $I->retrieveEntityField('simplecategory', 'name', 'test') . "')]"); // stepKey: selectCategory
		$I->comment("Entering Action Group [clickInsertWidget] AdminClickInsertWidgetActionGroup");
		$I->click("#insert_button"); // stepKey: clickInsertWidgetButtonClickInsertWidget
		$I->waitForPageLoad(30); // stepKey: clickInsertWidgetButtonClickInsertWidgetWaitForPageLoad
		$I->waitForElementNotVisible("//h1[contains(text(),'Insert Widget')]", 30); // stepKey: waitForWidgetPopupDisappearClickInsertWidget
		$I->comment("Exiting Action Group [clickInsertWidget] AdminClickInsertWidgetActionGroup");
		$I->comment("Save cms page and go to Storefront");
		$I->comment("Entering Action Group [saveCmsPage] SaveCmsPageActionGroup");
		$I->waitForElementVisible("//button[@data-ui-id='save-button-dropdown']", 30); // stepKey: waitForSplitButtonSaveCmsPage
		$I->waitForPageLoad(10); // stepKey: waitForSplitButtonSaveCmsPageWaitForPageLoad
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitButtonSaveCmsPage
		$I->waitForPageLoad(10); // stepKey: expandSplitButtonSaveCmsPageWaitForPageLoad
		$I->waitForElementVisible("#save_and_close", 30); // stepKey: waitForSaveCmsPageSaveCmsPage
		$I->waitForPageLoad(10); // stepKey: waitForSaveCmsPageSaveCmsPageWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSaveCmsPageSaveCmsPage
		$I->waitForPageLoad(10); // stepKey: clickSaveCmsPageSaveCmsPageWaitForPageLoad
		$I->waitForElementVisible("#add", 1); // stepKey: waitForCmsPageSaveButtonSaveCmsPage
		$I->waitForPageLoad(30); // stepKey: waitForCmsPageSaveButtonSaveCmsPageWaitForPageLoad
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveCmsPage
		$I->see("You saved the page.", ".message-success"); // stepKey: assertSavePageSuccessMessageSaveCmsPage
		$I->comment("Exiting Action Group [saveCmsPage] SaveCmsPageActionGroup");
		$I->comment("Entering Action Group [navigateToTheStoreFront1] NavigateToStorefrontForCreatedPageActionGroup");
		$I->amOnPage($I->retrieveEntityField('createPreReqPage', 'identifier', 'test')); // stepKey: goToStorefrontNavigateToTheStoreFront1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToTheStoreFront1
		$I->comment("Exiting Action Group [navigateToTheStoreFront1] NavigateToStorefrontForCreatedPageActionGroup");
		$I->comment("Check order of products: recently added first");
		$I->waitForElementVisible("//*[@class='product-items widget-product-grid']//*[@class='product-item'][1]//a[contains(text(), '" . $I->retrieveEntityField('createThirdProduct', 'name', 'test') . "')]", 30); // stepKey: waitForThirdProductVisible
		$I->seeElement("//*[@class='product-items widget-product-grid']//*[@class='product-item'][1]//a[contains(text(), '" . $I->retrieveEntityField('createThirdProduct', 'name', 'test') . "')]"); // stepKey: seeElementByName1
		$I->seeElement("//*[@class='product-items widget-product-grid']//*[@class='product-item'][2]//a[contains(text(), '" . $I->retrieveEntityField('createSecondProduct', 'name', 'test') . "')]"); // stepKey: seeElementByName2
		$I->seeElement("//*[@class='product-items widget-product-grid']//*[@class='product-item'][3]//a[contains(text(), '" . $I->retrieveEntityField('createFirstProduct', 'name', 'test') . "')]"); // stepKey: seeElementByName3
	}
}
