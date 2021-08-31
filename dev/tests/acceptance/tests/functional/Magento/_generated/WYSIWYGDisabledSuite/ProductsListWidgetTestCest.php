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
 * @Title("MAGETWO-97041: Admin should be able to set Products List Widget")
 * @Description("Admin should be able to set Products List Widget<h3>Test files</h3>app/code/Magento/Widget/Test/Mftf/Test/ProductsListWidgetTest.xml<br>")
 * @TestCaseId("MAGETWO-97041")
 * @group Widget
 * @group WYSIWYGDisabled
 */
class ProductsListWidgetTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilter
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
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
	 * @Features({"Widget"})
	 * @Stories({"Products list widget"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function ProductsListWidgetTest(AcceptanceTester $I)
	{
		$I->comment("Create a CMS page containing the Products List widget");
		$I->comment("Entering Action Group [amOnCmsList] AdminOpenCMSPagesGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridAmOnCmsList
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAmOnCmsList
		$I->comment("Exiting Action Group [amOnCmsList] AdminOpenCMSPagesGridActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFilters
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersWaitForPageLoad
		$I->comment("Entering Action Group [clickAddNewPageButton] AdminClickAddNewPageOnPagesGridActionGroup");
		$I->click("#add"); // stepKey: clickAddNewPageClickAddNewPageButton
		$I->waitForPageLoad(30); // stepKey: clickAddNewPageClickAddNewPageButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickAddNewPageButton
		$I->comment("Exiting Action Group [clickAddNewPageButton] AdminClickAddNewPageOnPagesGridActionGroup");
		$I->comment("Entering Action Group [fillPageTitle] AdminCmsPageSetTitleActionGroup");
		$I->fillField("input[name=title]", "Test CMS Page" . msq("_newDefaultCmsPage")); // stepKey: fillNewTitleFillPageTitle
		$I->comment("Exiting Action Group [fillPageTitle] AdminCmsPageSetTitleActionGroup");
		$I->comment("Entering Action Group [expandContentSection] AdminExpandContentSectionActionGroup");
		$I->click("div[data-index=content]"); // stepKey: expandContentSectionExpandContentSection
		$I->waitForPageLoad(30); // stepKey: waitForContentSectionExpandContentSection
		$I->comment("Exiting Action Group [expandContentSection] AdminExpandContentSectionActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [clickInsertWidgetButton] AdminInsertCatalogProductsListWidgetForCmsPageContentSectionActionGroup");
		$I->click(".action-add-widget"); // stepKey: clickInsertWidgetButtonClickInsertWidgetButton
		$I->waitForPageLoad(30); // stepKey: waitForSlideOutClickInsertWidgetButton
		$I->selectOption("#select_widget_type", "Catalog Products List"); // stepKey: selectWidgetTypeClickInsertWidgetButton
		$I->waitForPageLoad(30); // stepKey: waitForWidgetOptionsClickInsertWidgetButton
		$I->fillField("[name='parameters[title]']", ""); // stepKey: setTitleClickInsertWidgetButton
		$I->selectOption("[name='parameters[show_pager]']", "No"); // stepKey: selectDisplayPageControlClickInsertWidgetButton
		$I->fillField("[name='parameters[products_count]']", "10"); // stepKey: fillNumberOfProductsToDisplayClickInsertWidgetButton
		$I->selectOption("[name='parameters[template]']", "Products Grid Template"); // stepKey: selectTemplateClickInsertWidgetButton
		$I->fillField("[name='parameters[cache_lifetime]']", ""); // stepKey: fillCacheLifetimeClickInsertWidgetButton
		$I->click(".rule-param.rule-param-new-child"); // stepKey: clickAddNewConditionClickInsertWidgetButton
		$I->selectOption("#conditions__1__new_child", "Magento\CatalogWidget\Model\Rule\Condition\Product|category_ids"); // stepKey: selectConditionClickInsertWidgetButton
		$I->waitForElement("#conditions__1__children>li:nth-child(1)>span:nth-child(4)>a", 30); // stepKey: waitRuleParameterClickInsertWidgetButton
		$I->click("#conditions__1__children>li:nth-child(1)>span:nth-child(4)>a"); // stepKey: clickRuleParameterClickInsertWidgetButton
		$I->click(".rule-chooser-trigger"); // stepKey: clickChooserClickInsertWidgetButton
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxLoadClickInsertWidgetButton
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]"); // stepKey: clickCategoryToEditInitialClickInsertWidgetButton
		$I->waitForPageLoad(30); // stepKey: clickCategoryToEditInitialClickInsertWidgetButtonWaitForPageLoad
		$I->click(".rule-param-apply"); // stepKey: clickApplyRuleParameterClickInsertWidgetButton
		$I->comment("Exiting Action Group [clickInsertWidgetButton] AdminInsertCatalogProductsListWidgetForCmsPageContentSectionActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [clickInsertWidget] AdminClickInsertWidgetActionGroup");
		$I->click("#insert_button"); // stepKey: clickInsertWidgetButtonClickInsertWidget
		$I->waitForPageLoad(30); // stepKey: clickInsertWidgetButtonClickInsertWidgetWaitForPageLoad
		$I->waitForElementNotVisible("//h1[contains(text(),'Insert Widget')]", 30); // stepKey: waitForWidgetPopupDisappearClickInsertWidget
		$I->comment("Exiting Action Group [clickInsertWidget] AdminClickInsertWidgetActionGroup");
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitBtn
		$I->waitForPageLoad(10); // stepKey: expandSplitBtnWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSaveAndClose
		$I->waitForPageLoad(10); // stepKey: clickSaveAndCloseWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCmsList2
		$I->comment("Entering Action Group [seeSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleSeeSuccessMessage
		$I->see("You saved the page.", "#messages div.message-success"); // stepKey: verifyMessageSeeSuccessMessage
		$I->comment("Exiting Action Group [seeSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearGridFilters
		$I->waitForPageLoad(30); // stepKey: clearGridFiltersWaitForPageLoad
		$I->comment("Verify CMS page on storefront");
		$I->waitForElementVisible("//div[text()='Test CMS Page" . msq("_newDefaultCmsPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']", 30); // stepKey: waitForCMSPageListItem
		$I->click("//div[text()='Test CMS Page" . msq("_newDefaultCmsPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelect
		$I->waitForElementVisible("//div[text()='Test CMS Page" . msq("_newDefaultCmsPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Edit']", 30); // stepKey: waitForEditLink
		$I->click("//div[text()='Test CMS Page" . msq("_newDefaultCmsPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='View']"); // stepKey: clickEdit
		$I->switchToNextTab(); // stepKey: switchToNextTab
		$I->waitForPageLoad(30); // stepKey: waitForCMSPage
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [seeProduct] AssertStorefrontProductIsShownOnCmsPageActionGroup");
		$I->seeInTitle("Test CMS Page" . msq("_newDefaultCmsPage")); // stepKey: seePageTitleSeeProduct
		$I->see($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), ".product-item-info"); // stepKey: seeProductNameSeeProduct
		$I->comment("Exiting Action Group [seeProduct] AssertStorefrontProductIsShownOnCmsPageActionGroup");
		$I->closeTab(); // stepKey: closeCurrentTab
	}
}
