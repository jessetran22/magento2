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
 * @Title("MC-42286: Date and time in export file name should be in user timezone")
 * @Description("Date and time in export file name should be in user timezone<h3>Test files</h3>app/code/Magento/CatalogImportExport/Test/Mftf/Test/AdminExportFilenameTimezoneTest.xml<br>")
 * @TestCaseId("MC-42286")
 * @group catalog_import_export
 */
class AdminExportFilenameTimezoneTestCest
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
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create simple product");
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
		$I->comment("Log in to admin");
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
		$I->comment("Delete product");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Log out from admin");
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
	 * @Features({"CatalogImportExport"})
	 * @Stories({"Export Products"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminExportFilenameTimezoneTest(AcceptanceTester $I)
	{
		$I->comment("Set timezone for default config");
		$I->comment("Entering Action Group [goToGeneralConfig] AdminOpenGeneralConfigurationPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/general/"); // stepKey: openGeneralConfigurationPageGoToGeneralConfig
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToGeneralConfig
		$I->comment("Exiting Action Group [goToGeneralConfig] AdminOpenGeneralConfigurationPageActionGroup");
		$I->conditionalClick("#general_locale-head", "#general_locale_timezone", false); // stepKey: openLocaleSection
		$originalTimezone = $I->grabValueFrom("#general_locale_timezone"); // stepKey: originalTimezone
		$I->selectOption("#general_locale_timezone", "America/Chicago"); // stepKey: setTimezone
		$I->click("#save"); // stepKey: saveConfig
		$I->waitForPageLoad(30); // stepKey: saveConfigWaitForPageLoad
		$I->comment("Navigate to export page");
		$I->comment("Entering Action Group [goToExportIndexPage] AdminNavigateToExportPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/export/"); // stepKey: navigateToExportPageGoToExportIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForExportPageOpenedGoToExportIndexPage
		$I->comment("Exiting Action Group [goToExportIndexPage] AdminNavigateToExportPageActionGroup");
		$I->comment("Export all products");
		$I->comment("Entering Action Group [exportCreatedProducts] ExportAllProductsActionGroup");
		$I->waitForElementVisible("#entity", 30); // stepKey: waitForEntityTypeDropDownExportCreatedProducts
		$I->selectOption("#entity", "Products"); // stepKey: selectProductsOptionExportCreatedProducts
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadExportCreatedProducts
		$I->waitForElementVisible("#export_filter_form", 30); // stepKey: waitForElementVisibleExportCreatedProducts
		$I->selectOption("#file_format", "CSV"); // stepKey: selectFileFormatExportCreatedProducts
		$I->scrollTo("//*[@id='export_filter_container']/button"); // stepKey: scrollToContinueExportCreatedProducts
		$I->waitForPageLoad(30); // stepKey: scrollToContinueExportCreatedProductsWaitForPageLoad
		$I->waitForElementVisible("//*[@id='export_filter_container']/button", 30); // stepKey: waitForScrollExportCreatedProducts
		$I->waitForPageLoad(30); // stepKey: waitForScrollExportCreatedProductsWaitForPageLoad
		$I->click("//*[@id='export_filter_container']/button"); // stepKey: clickContinueButtonExportCreatedProducts
		$I->waitForPageLoad(30); // stepKey: clickContinueButtonExportCreatedProductsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickExportCreatedProducts
		$I->waitForText("Message is added to queue, wait to get your file soon. Make sure your cron job is running to export the file", 30, "#messages div.message-success"); // stepKey: seeSuccessMessageExportCreatedProducts
		$I->comment("Exiting Action Group [exportCreatedProducts] ExportAllProductsActionGroup");
		$I->comment("Start queue consumer for export");
		$I->comment("Entering Action Group [startMessageQueue] CliConsumerStartActionGroup");
		$startMessageQueueStartMessageQueue = $I->magentoCLI("queue:consumers:start exportProcessor --max-messages=100", 60); // stepKey: startMessageQueueStartMessageQueue
		$I->comment($startMessageQueueStartMessageQueue);
		$I->comment("Exiting Action Group [startMessageQueue] CliConsumerStartActionGroup");
		$I->comment("Refresh export page");
		$I->comment("Entering Action Group [refreshPage] ReloadPageActionGroup");
		$I->reloadPage(); // stepKey: reloadPageRefreshPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadRefreshPage
		$I->comment("Exiting Action Group [refreshPage] ReloadPageActionGroup");
		$I->comment("Get file display name");
		$I->waitForElementVisible("[data-role='grid'] tr[data-repeat-index='0'] div.data-grid-cell-content", 30); // stepKey: waitForFilename
		$getFilename = $I->grabTextFrom("[data-role='grid'] tr[data-repeat-index='0'] div.data-grid-cell-content"); // stepKey: getFilename
		$I->comment("Get file name on server");
		$I->comment("Entering Action Group [grabNameFile] AdminGetExportFilenameOnServerActionGroup");
		$I->waitForElementVisible("//tr[@data-repeat-index='0']//button", 30); // stepKey: waitForTheRowGrabNameFile
		$I->waitForPageLoad(30); // stepKey: waitForTheRowGrabNameFileWaitForPageLoad
		$grabDownloadUrlGrabNameFile = $I->grabAttributeFrom("//tr[@data-repeat-index='0']//a[text()='Download']", "href"); // stepKey: grabDownloadUrlGrabNameFile
		$I->waitForPageLoad(30); // stepKey: grabDownloadUrlGrabNameFileWaitForPageLoad
		$grabFilenameGrabNameFile = $I->executeJS("var href = '{$grabDownloadUrlGrabNameFile}';  return href.toQueryParams().filename;"); // stepKey: grabFilenameGrabNameFile
		$grabNameFile = $I->return($grabFilenameGrabNameFile); // stepKey: returnFilenameGrabNameFile
		$I->comment("Exiting Action Group [grabNameFile] AdminGetExportFilenameOnServerActionGroup");
		$I->comment("Verify that the file exists on server");
		$I->comment('[assertExportFileExists] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::assertFileExists()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->assertFileExists("var/export/{$grabNameFile}", ''); // stepKey: assertExportFileExists
		$timestamp = $I->executeJS("var dt = '{$grabNameFile}'.replace(/[^\d]/g, ''),              dy = dt.substring(0, 4),              dm = dt.substring(4, 6),              dd = dt.substring(6, 8),              dh = dt.substring(8, 10),              dmn = dt.substring(10, 12),              ds = dt.substring(12);              return (Date.parse(dy + '-' + dm + '-' + dd + 'T' + dh + ':' + dmn + ':' + ds +  '.000Z')/1000);"); // stepKey: timestamp
		$date = new \DateTime();
		$date->setTimestamp(strtotime("@{$timestamp}"));
		$date->setTimezone(new \DateTimeZone("America/Chicago"));
		$expectedDate = $date->format("Ymd_His");

		$expectedFilename = $I->executeJS("return 'catalog_product_' + '{$expectedDate}' + '.csv'"); // stepKey: expectedFilename
		$I->comment("Verify that the date and time in export filename is in user timezone");
		$I->assertEquals($expectedFilename, $getFilename); // stepKey: assertThatFilenameDisplayedToUserIsInAdminTimezone
		$I->comment("Verify that the date and time in download filename is in user timezone");
		$grabExportUrl = $I->grabAttributeFrom("//tr[@data-repeat-index='0']//a[text()='Download']", "href"); // stepKey: grabExportUrl
		$I->waitForPageLoad(30); // stepKey: grabExportUrlWaitForPageLoad
		$I->comment('[assertDownloadFileContainsConfigurableProduct] \Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseHeadersContainsString()');
		$this->helperContainer->get('\Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseHeadersContainsString($grabExportUrl, "Content-Disposition: attachment; filename=\"export/{$expectedFilename}\"", NULL, 'admin'); // stepKey: assertDownloadFileContainsConfigurableProduct
		$I->comment("Delete export File");
		$I->comment("Entering Action Group [deleteExportedFile] DeleteExportedFileActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/export/"); // stepKey: goToExportIndexPageDeleteExportedFile
		$I->waitForPageLoad(30); // stepKey: waitFormReloadDeleteExportedFile
		$I->click("//div[@class='data-grid-cell-content'][text()='{$getFilename}']/../..//button[@class='action-select']"); // stepKey: clickSelectBtnDeleteExportedFile
		$I->click("//div[@class='data-grid-cell-content'][text()='{$getFilename}']/../..//a[text()='Delete']"); // stepKey: clickOnDeleteDeleteExportedFile
		$I->waitForPageLoad(30); // stepKey: clickOnDeleteDeleteExportedFileWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteExportedFile
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmDeleteDeleteExportedFile
		$I->waitForPageLoad(60); // stepKey: confirmDeleteDeleteExportedFileWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitFormReload2DeleteExportedFile
		$I->dontSeeElement("//div[@class='data-grid-cell-content'][text()='{$getFilename}']"); // stepKey: assertDontSeeFileDeleteExportedFile
		$I->comment("Exiting Action Group [deleteExportedFile] DeleteExportedFileActionGroup");
		$I->comment("Reset timezone");
		$I->comment("Entering Action Group [goToGeneralConfigReset] AdminOpenGeneralConfigurationPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/general/"); // stepKey: openGeneralConfigurationPageGoToGeneralConfigReset
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToGeneralConfigReset
		$I->comment("Exiting Action Group [goToGeneralConfigReset] AdminOpenGeneralConfigurationPageActionGroup");
		$I->conditionalClick("#general_locale-head", "#general_locale_timezone", false); // stepKey: openLocaleSectionReset
		$I->selectOption("#general_locale_timezone", "$originalTimezone"); // stepKey: resetTimezone
		$I->click("#save"); // stepKey: saveConfigReset
		$I->waitForPageLoad(30); // stepKey: saveConfigResetWaitForPageLoad
	}
}
