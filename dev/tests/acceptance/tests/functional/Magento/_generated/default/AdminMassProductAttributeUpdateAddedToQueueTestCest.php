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
 * @Title("MC-28990: Check functionality of RabbitMQ")
 * @Description("Mass product attribute update task should be added to the queue<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminMassProductAttributeUpdateAddedToQueueTest.xml<br>")
 * @TestCaseId("MC-28990")
 * @group catalog
 * @group asynchronousOperations
 */
class AdminMassProductAttributeUpdateAddedToQueueTestCest
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
		$I->createEntity("createFirstProduct", "hook", "ApiProductWithDescription", [], []); // stepKey: createFirstProduct
		$I->createEntity("createSecondProduct", "hook", "ApiProductWithDescription", [], []); // stepKey: createSecondProduct
		$I->createEntity("createThirdProduct", "hook", "ApiProductNameWithNoSpaces", [], []); // stepKey: createThirdProduct
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
		$I->deleteEntity("createFirstProduct", "hook"); // stepKey: deleteFirstProduct
		$I->deleteEntity("createSecondProduct", "hook"); // stepKey: deleteSecondProduct
		$I->deleteEntity("createThirdProduct", "hook"); // stepKey: deleteThirdProduct
		$I->comment("Entering Action Group [clearProductFilter] ClearProductsFilterActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexClearProductFilter
		$I->waitForPageLoad(30); // stepKey: waitForProductsPageToLoadClearProductFilter
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetClearProductFilter
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetClearProductFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductFilter] ClearProductsFilterActionGroup");
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
	 * @Features({"Catalog"})
	 * @Stories({"Mass update product attributes"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMassProductAttributeUpdateAddedToQueueTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [searchByKeyword] SearchProductGridByKeyword2ActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialSearchByKeyword
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialSearchByKeywordWaitForPageLoad
		$I->fillField("input#fulltext", "api-simple-product"); // stepKey: fillKeywordSearchFieldSearchByKeyword
		$I->click(".data-grid-search-control-wrap button.action-submit"); // stepKey: clickKeywordSearchSearchByKeyword
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchSearchByKeywordWaitForPageLoad
		$I->comment("Exiting Action Group [searchByKeyword] SearchProductGridByKeyword2ActionGroup");
		$I->comment("Entering Action Group [sortProductsByIdDescending] SortProductsByIdDescendingActionGroup");
		$I->conditionalClick(".//*[@class='sticky-header']/following-sibling::*//th[@class='data-grid-th _sortable _draggable _ascend']/span[text()='ID']", ".//*[@class='sticky-header']/following-sibling::*//th[@class='data-grid-th _sortable _draggable _descend']/span[text()='ID']", false); // stepKey: sortByIdSortProductsByIdDescending
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSortProductsByIdDescending
		$I->comment("Exiting Action Group [sortProductsByIdDescending] SortProductsByIdDescendingActionGroup");
		$I->click("//*[@id='container']//tr[1]/td[1]//input"); // stepKey: selectThirdProduct
		$I->click("//*[@id='container']//tr[2]/td[1]//input"); // stepKey: selectSecondProduct
		$I->click("//*[@id='container']//tr[3]/td[1]//input"); // stepKey: selectFirstProduct
		$I->comment("Entering Action Group [goToUpdateProductAttributesPage] AdminClickMassUpdateProductAttributesActionGroup");
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickDropdownGoToUpdateProductAttributesPage
		$I->waitForPageLoad(30); // stepKey: clickDropdownGoToUpdateProductAttributesPageWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Update attributes']"); // stepKey: clickOptionGoToUpdateProductAttributesPage
		$I->waitForPageLoad(30); // stepKey: clickOptionGoToUpdateProductAttributesPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForBulkUpdatePageGoToUpdateProductAttributesPage
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_action_attribute/edit/"); // stepKey: seeInUrlGoToUpdateProductAttributesPage
		$I->comment("Exiting Action Group [goToUpdateProductAttributesPage] AdminClickMassUpdateProductAttributesActionGroup");
		$I->checkOption("#toggle_short_description"); // stepKey: toggleToChangeShortDescription
		$I->fillField("#short_description", "Test Update"); // stepKey: fillShortDescriptionField
		$I->comment("Entering Action Group [saveMassAttributeUpdate] AdminSaveProductsMassAttributesUpdateActionGroup");
		$I->click("button[title=Save]"); // stepKey: saveSaveMassAttributeUpdate
		$I->waitForPageLoad(30); // stepKey: saveSaveMassAttributeUpdateWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 60); // stepKey: waitForSuccessMessageSaveMassAttributeUpdate
		$I->see("Message is added to queue", "#messages div.message-success"); // stepKey: assertSuccessMessageSaveMassAttributeUpdate
		$I->comment("Exiting Action Group [saveMassAttributeUpdate] AdminSaveProductsMassAttributesUpdateActionGroup");
		$I->see("Task \"Update attributes for 3 selected products\": 1 item(s) have been scheduled for update.", "#system_messages div.message-info"); // stepKey: seeInfoMessage
		$I->click("//div[contains(@class, 'message-system-short')]/a[contains(text(), 'View Details')]"); // stepKey: seeDetails
		$I->waitForPageLoad(30); // stepKey: seeDetailsWaitForPageLoad
		$I->see("Update attributes for 3 selected products", "//aside//div[@data-index='description']//span[@name='description']"); // stepKey: seeDescription
		$I->see("Pending, in queue...", "//aside//div[@data-index='summary']//span[@name='summary']"); // stepKey: seeSummary
		$grabStartTimeValue = $I->grabTextFrom("//aside//div[@data-index='start_time']//span[@name='start_time']"); // stepKey: grabStartTimeValue
		$I->assertRegExp("/\d{1,2}\/\d{2}\/\d{4}\s\d{1,2}:\d{2}:\d{2}\s(AM|PM)/", $grabStartTimeValue); // stepKey: assertStartTime
	}
}
