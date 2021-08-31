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
 * @Title("MC-41972: Admin should be able to mass update datetime attribute")
 * @Description("Admin should be able to mass update datetime attribute<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminMassUpdateProductAttributeDatetimeTest.xml<br>")
 * @TestCaseId("MC-41972")
 * @group catalog
 * @group product_attributes
 */
class AdminMassUpdateProductAttributeDatetimeTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProductOne", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProductOne
		$I->createEntity("createProductTwo", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProductTwo
		$I->comment("Create new datetime product attribute");
		$I->createEntity("createDatetimeProduct", "hook", "DatetimeProductAttribute", [], []); // stepKey: createDatetimeProduct
		$I->createEntity("addToDefaultSet", "hook", "AddToDefaultSet", ["createDatetimeProduct"], []); // stepKey: addToDefaultSet
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createProductOne", "hook"); // stepKey: deleteProductOne
		$I->deleteEntity("createProductTwo", "hook"); // stepKey: deleteProductTwo
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [clearProductFilter] ClearProductsFilterActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexClearProductFilter
		$I->waitForPageLoad(30); // stepKey: waitForProductsPageToLoadClearProductFilter
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetClearProductFilter
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetClearProductFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductFilter] ClearProductsFilterActionGroup");
		$I->deleteEntity("createDatetimeProduct", "hook"); // stepKey: deleteDatetimeProduct
		$I->comment("Entering Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAmOnLogoutPage
		$I->comment("Exiting Action Group [amOnLogoutPage] AdminLogoutActionGroup");
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
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMassUpdateProductAttributeDatetimeTest(AcceptanceTester $I)
	{
		$I->comment("Generate the datetime default value");
		$date = new \DateTime();
		$date->setTimestamp(strtotime("+1 day"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$randomDatetime = $date->format("m/j/Y g:i A");

		$I->comment("Navigate to products list page and select created products");
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
		$I->click("//*[@id='container']//tr[1]/td[1]//input"); // stepKey: clickCheckbox1
		$I->click("//*[@id='container']//tr[2]/td[1]//input"); // stepKey: clickCheckbox2
		$I->comment("Mass update qty increments");
		$I->comment("Entering Action Group [clickMassUpdateProductAttributes] AdminClickMassUpdateProductAttributesActionGroup");
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickDropdownClickMassUpdateProductAttributes
		$I->waitForPageLoad(30); // stepKey: clickDropdownClickMassUpdateProductAttributesWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Update attributes']"); // stepKey: clickOptionClickMassUpdateProductAttributes
		$I->waitForPageLoad(30); // stepKey: clickOptionClickMassUpdateProductAttributesWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForBulkUpdatePageClickMassUpdateProductAttributes
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_action_attribute/edit/"); // stepKey: seeInUrlClickMassUpdateProductAttributes
		$I->comment("Exiting Action Group [clickMassUpdateProductAttributes] AdminClickMassUpdateProductAttributesActionGroup");
		$I->comment("Entering Action Group [updateAttribute] AdminMassUpdateProductAttributeActionGroup");
		$I->checkOption("#toggle_" . $I->retrieveEntityField('createDatetimeProduct', 'attribute_code', 'test')); // stepKey: toggleAttributeUpdateAttribute
		$I->fillField("#" . $I->retrieveEntityField('createDatetimeProduct', 'attribute_code', 'test'), $randomDatetime); // stepKey: setAttributeValueUpdateAttribute
		$I->comment("Exiting Action Group [updateAttribute] AdminMassUpdateProductAttributeActionGroup");
		$I->comment("Entering Action Group [saveForm] AdminMassUpdateProductAttributeSaveActionGroup");
		$I->click("button[title='Save']"); // stepKey: saveSaveForm
		$I->waitForPageLoad(30); // stepKey: saveSaveFormWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitVisibleSuccessMessageSaveForm
		$I->see("Message is added to queue", "#messages div.message-success"); // stepKey: seeSuccessMessageSaveForm
		$I->comment("Exiting Action Group [saveForm] AdminMassUpdateProductAttributeSaveActionGroup");
		$I->comment("Start message queue for product attribute consumer");
		$I->comment("Entering Action Group [startMessageQueue] CliConsumerStartActionGroup");
		$startMessageQueueStartMessageQueue = $I->magentoCLI("queue:consumers:start product_action_attribute.update --max-messages=100", 60); // stepKey: startMessageQueueStartMessageQueue
		$I->comment($startMessageQueueStartMessageQueue);
		$I->comment("Exiting Action Group [startMessageQueue] CliConsumerStartActionGroup");
		$I->comment("Open first product for edit and assert that qty increment is updated");
		$I->comment("Entering Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProductOne', 'id', 'test')); // stepKey: goToProductGoToProductEditPage
		$I->comment("Exiting Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->seeInField("//input[contains(@name, 'product[" . $I->retrieveEntityField('createDatetimeProduct', 'attribute_code', 'test') . "]')]", $randomDatetime); // stepKey: assertQtyIncrementsValue
		$I->comment("Open second product for edit and assert that qty increment is updated");
		$I->comment("Entering Action Group [goToProductEditPage2] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProductTwo', 'id', 'test')); // stepKey: goToProductGoToProductEditPage2
		$I->comment("Exiting Action Group [goToProductEditPage2] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad2
		$I->seeInField("//input[contains(@name, 'product[" . $I->retrieveEntityField('createDatetimeProduct', 'attribute_code', 'test') . "]')]", $randomDatetime); // stepKey: assertQtyIncrementsValue2
	}
}
