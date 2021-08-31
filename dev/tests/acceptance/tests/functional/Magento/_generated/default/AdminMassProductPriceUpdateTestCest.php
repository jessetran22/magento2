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
 * @Title("MC-8510: Mass update simple product price")
 * @Description("Login as admin and update mass product price<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminMassProductPriceUpdateTest.xml<br>")
 * @TestCaseId("MC-8510")
 * @group mtf_migrated
 */
class AdminMassProductPriceUpdateTestCest
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
		$I->createEntity("simpleProduct1", "hook", "defaultSimpleProduct", [], []); // stepKey: simpleProduct1
		$I->createEntity("simpleProduct2", "hook", "defaultSimpleProduct", [], []); // stepKey: simpleProduct2
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("simpleProduct2", "hook"); // stepKey: deleteSimpleProduct2
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
	 * @Stories({"Mass product update"})
	 * @Features({"Catalog"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMassProductPriceUpdateTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [searchByKeyword] ClearFiltersAdminProductGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchByKeyword
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchByKeywordWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadSearchByKeyword
		$I->comment("Exiting Action Group [searchByKeyword] ClearFiltersAdminProductGridActionGroup");
		$I->comment("Entering Action Group [sortProductsByIdDescending] SortProductsByIdDescendingActionGroup");
		$I->conditionalClick(".//*[@class='sticky-header']/following-sibling::*//th[@class='data-grid-th _sortable _draggable _ascend']/span[text()='ID']", ".//*[@class='sticky-header']/following-sibling::*//th[@class='data-grid-th _sortable _draggable _descend']/span[text()='ID']", false); // stepKey: sortByIdSortProductsByIdDescending
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSortProductsByIdDescending
		$I->comment("Exiting Action Group [sortProductsByIdDescending] SortProductsByIdDescendingActionGroup");
		$I->comment("Entering Action Group [selectFirstProduct] AdminCheckProductOnProductGridActionGroup");
		$I->checkOption("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('simpleProduct1', 'sku', 'test') . "']]/../td//input[@data-action='select-row']"); // stepKey: selectProductSelectFirstProduct
		$I->comment("Exiting Action Group [selectFirstProduct] AdminCheckProductOnProductGridActionGroup");
		$I->comment("Entering Action Group [selectSecondProduct] AdminCheckProductOnProductGridActionGroup");
		$I->checkOption("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('simpleProduct2', 'sku', 'test') . "']]/../td//input[@data-action='select-row']"); // stepKey: selectProductSelectSecondProduct
		$I->comment("Exiting Action Group [selectSecondProduct] AdminCheckProductOnProductGridActionGroup");
		$I->comment("Entering Action Group [clickDropdown] AdminClickMassUpdateProductAttributesActionGroup");
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickDropdownClickDropdown
		$I->waitForPageLoad(30); // stepKey: clickDropdownClickDropdownWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Update attributes']"); // stepKey: clickOptionClickDropdown
		$I->waitForPageLoad(30); // stepKey: clickOptionClickDropdownWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForBulkUpdatePageClickDropdown
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_action_attribute/edit/"); // stepKey: seeInUrlClickDropdown
		$I->comment("Exiting Action Group [clickDropdown] AdminClickMassUpdateProductAttributesActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [scrollToPriceCheckBox] AdminSetPriceForMassUpdateActionGroup");
		$I->scrollTo("#toggle_price", 0, -160); // stepKey: scrollToPriceCheckBoxScrollToPriceCheckBox
		$I->click("#toggle_price"); // stepKey: selectPriceCheckBoxScrollToPriceCheckBox
		$I->fillField("#price", "90.99"); // stepKey: fillPriceScrollToPriceCheckBox
		$I->comment("Exiting Action Group [scrollToPriceCheckBox] AdminSetPriceForMassUpdateActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [clickOnSaveButton] AdminSaveProductsMassAttributesUpdateActionGroup");
		$I->click("button[title=Save]"); // stepKey: saveClickOnSaveButton
		$I->waitForPageLoad(30); // stepKey: saveClickOnSaveButtonWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 60); // stepKey: waitForSuccessMessageClickOnSaveButton
		$I->see("Message is added to queue", "#messages div.message-success"); // stepKey: assertSuccessMessageClickOnSaveButton
		$I->comment("Exiting Action Group [clickOnSaveButton] AdminSaveProductsMassAttributesUpdateActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [startMessageQueueConsumer] CliConsumerStartActionGroup");
		$startMessageQueueStartMessageQueueConsumer = $I->magentoCLI("queue:consumers:start product_action_attribute.update --max-messages=100", 60); // stepKey: startMessageQueueStartMessageQueueConsumer
		$I->comment($startMessageQueueStartMessageQueueConsumer);
		$I->comment("Exiting Action Group [startMessageQueueConsumer] CliConsumerStartActionGroup");
		$runCron = $I->magentoCLI("cron:run --group=index", 60); // stepKey: runCron
		$I->comment($runCron);
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [waitForFirstProductToLoad] AssertAdminProductPriceUpdatedOnEditPageActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('simpleProduct1', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowWaitForFirstProductToLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadWaitForFirstProductToLoad
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('simpleProduct1', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageWaitForFirstProductToLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadWaitForFirstProductToLoad
		$I->seeInField(".admin__field[data-index=name] input", $I->retrieveEntityField('simpleProduct1', 'name', 'test')); // stepKey: seeProductNameWaitForFirstProductToLoad
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('simpleProduct1', 'sku', 'test')); // stepKey: seeProductSkuWaitForFirstProductToLoad
		$I->seeInField(".admin__field[data-index=price] input", "90.99"); // stepKey: seeProductPriceWaitForFirstProductToLoad
		$I->comment("Exiting Action Group [waitForFirstProductToLoad] AssertAdminProductPriceUpdatedOnEditPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [waitForProductsToLoad] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageWaitForProductsToLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadWaitForProductsToLoad
		$I->comment("Exiting Action Group [waitForProductsToLoad] AdminOpenProductIndexPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [waitForSecondProductToLoad] AssertAdminProductPriceUpdatedOnEditPageActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('simpleProduct2', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowWaitForSecondProductToLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadWaitForSecondProductToLoad
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('simpleProduct2', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageWaitForSecondProductToLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadWaitForSecondProductToLoad
		$I->seeInField(".admin__field[data-index=name] input", $I->retrieveEntityField('simpleProduct2', 'name', 'test')); // stepKey: seeProductNameWaitForSecondProductToLoad
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('simpleProduct2', 'sku', 'test')); // stepKey: seeProductSkuWaitForSecondProductToLoad
		$I->seeInField(".admin__field[data-index=price] input", "90.99"); // stepKey: seeProductPriceWaitForSecondProductToLoad
		$I->comment("Exiting Action Group [waitForSecondProductToLoad] AssertAdminProductPriceUpdatedOnEditPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
	}
}
