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
 * @Title("MAGETWO-97224: Check that URL for product rewritten correctly")
 * @Description("Check that URL for product rewritten correctly<h3>Test files</h3>app/code/Magento/CatalogUrlRewrite/Test/Mftf/Test/AdminUrlForProductRewrittenCorrectlyTest.xml<br>")
 * @TestCaseId("MAGETWO-97224")
 * @group CatalogUrlRewrite
 */
class AdminUrlForProductRewrittenCorrectlyTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create product");
		$I->createEntity("category", "hook", "_defaultCategory", [], []); // stepKey: category
		$I->createEntity("createProduct", "hook", "ApiSimpleProduct", ["category"], []); // stepKey: createProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created data");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
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
	 * @Features({"CatalogUrlRewrite"})
	 * @Stories({"Url rewrites"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUrlForProductRewrittenCorrectlyTest(AcceptanceTester $I)
	{
		$I->comment("Open Created product");
		$I->comment("Entering Action Group [amOnEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct', 'id', 'test')); // stepKey: goToProductAmOnEditPage
		$I->comment("Exiting Action Group [amOnEditPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForEditPage
		$I->comment("Switch to Default Store view");
		$I->comment("Entering Action Group [selectSecondStoreView] SwitchToTheNewStoreViewActionGroup");
		$I->scrollTo("//*[@class='page-header row']"); // stepKey: scrollToUpSelectSecondStoreView
		$I->waitForElementVisible("#store-change-button", 30); // stepKey: waitForElementBecomeVisibleSelectSecondStoreView
		$I->waitForPageLoad(10); // stepKey: waitForElementBecomeVisibleSelectSecondStoreViewWaitForPageLoad
		$I->click("#store-change-button"); // stepKey: clickStoreviewSwitcherSelectSecondStoreView
		$I->waitForPageLoad(10); // stepKey: clickStoreviewSwitcherSelectSecondStoreViewWaitForPageLoad
		$I->click("//ul[@data-role='stores-list']/li/a[normalize-space(.)='Default Store View']"); // stepKey: chooseStoreViewSelectSecondStoreView
		$I->waitForPageLoad(10); // stepKey: chooseStoreViewSelectSecondStoreViewWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: acceptStoreSwitchingMessageSelectSecondStoreView
		$I->waitForPageLoad(60); // stepKey: acceptStoreSwitchingMessageSelectSecondStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectSecondStoreView
		$I->comment("Exiting Action Group [selectSecondStoreView] SwitchToTheNewStoreViewActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewLoad
		$I->comment("Set use default url");
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: clickOnSearchEngineOptimization
		$I->waitForPageLoad(30); // stepKey: clickOnSearchEngineOptimizationWaitForPageLoad
		$I->waitForElementVisible("input[name='use_default[url_key]']", 30); // stepKey: waitForUseDefaultUrlCheckbox
		$I->click("input[name='use_default[url_key]']"); // stepKey: clickUseDefaultUrlCheckbox
		$I->fillField("input[name='product[url_key]']", $I->retrieveEntityField('createProduct', 'sku', 'test') . "-new"); // stepKey: changeUrlKey
		$I->comment("Entering Action Group [saveProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct
		$I->comment("Exiting Action Group [saveProduct] SaveProductFormActionGroup");
		$I->comment("Select product and go toUpdate Attribute page");
		$I->comment("Entering Action Group [goToCatalogPageChangingView] AdminProductCatalogPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openProductCatalogPageGoToCatalogPageChangingView
		$I->waitForPageLoad(30); // stepKey: waitForProductCatalogPageLoadGoToCatalogPageChangingView
		$I->comment("Exiting Action Group [goToCatalogPageChangingView] AdminProductCatalogPageOpenActionGroup");
		$I->comment("Entering Action Group [filterBundleProductOptionsDownToName] FilterProductGridByNameActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterBundleProductOptionsDownToName
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterBundleProductOptionsDownToNameWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterBundleProductOptionsDownToName
		$I->fillField("input.admin__control-text[name='name']", "Api Simple Product" . msq("ApiSimpleProduct")); // stepKey: fillProductNameFilterFilterBundleProductOptionsDownToName
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterBundleProductOptionsDownToName
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterBundleProductOptionsDownToNameWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterBundleProductOptionsDownToName
		$I->comment("Exiting Action Group [filterBundleProductOptionsDownToName] FilterProductGridByNameActionGroup");
		$I->click("//div[@data-role='grid-wrapper']//label[@data-bind='attr: {for: ko.uid}']"); // stepKey: ClickOnSelectAllCheckBoxChangingView
		$I->waitForPageLoad(30); // stepKey: ClickOnSelectAllCheckBoxChangingViewWaitForPageLoad
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdown
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Update attributes']"); // stepKey: clickBulkUpdate
		$I->waitForPageLoad(30); // stepKey: clickBulkUpdateWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForUpdateAttributesPageLoad
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_action_attribute/edit/"); // stepKey: seeInUrlAttributeUpdatePage
		$I->click("#attributes_update_tabs_websites"); // stepKey: clickWebsiteTab
		$I->waitForAjaxLoad(30); // stepKey: waitForLoadWebSiteTab
		$I->click("#add-products-to-website-content .website-checkbox"); // stepKey: checkAddProductToWebsiteCheckbox
		$I->click("button[title='Save']"); // stepKey: clickSave
		$I->waitForPageLoad(30); // stepKey: clickSaveWaitForPageLoad
		$I->see("Message is added to queue", ".message.message-success.success"); // stepKey: seeSaveSuccess
		$I->comment("Start message queue");
		$I->comment("Entering Action Group [startMessageQueueConsumer] CliConsumerStartActionGroup");
		$startMessageQueueStartMessageQueueConsumer = $I->magentoCLI("queue:consumers:start product_action_attribute.website.update --max-messages=100", 60); // stepKey: startMessageQueueStartMessageQueueConsumer
		$I->comment($startMessageQueueStartMessageQueueConsumer);
		$I->comment("Exiting Action Group [startMessageQueueConsumer] CliConsumerStartActionGroup");
		$I->comment("Run cron");
		$runCron = $I->magentoCLI("cron:run --group=index", 60); // stepKey: runCron
		$I->comment($runCron);
		$I->comment("Got to Store front product page and check url");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . "-new.html"); // stepKey: navigateToSimpleProductPage
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . "-new.html"); // stepKey: seeProductNewUrl
	}
}
