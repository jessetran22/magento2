<?php
namespace Magento\AcceptanceTest\_MediaGalleryUiSuite\Backend;

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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/1320712/scenarios/3961351: DEPRECATED. User edits image meta data in standalone media gallery")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/1320712/scenarios/3961351")
 * @Description("User edits image meta data in Standalone Media Gallery<h3 class='y-label y-label_status_broken'>Deprecated Notice(s):</h3><ul><li>Use AdminStandaloneMediaGalleryEditImageDetailsFromDialogTest instead</li></ul><h3>Test files</h3>app/code/Magento/MediaGalleryUi/Test/Mftf/Test/AdminStandaloneMediaGalleryEditImageDetailsTest.xml<br>")
 * @group media_gallery_ui
 */
class AdminStandaloneMediaGalleryEditImageDetailsTestCest
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
        $this->helperContainer->create("Magento\MediaGalleryUi\Test\Mftf\Helper\MediaGalleryUiHelper");
    }
	/**
	 * @Features({"MediaGalleryUi"})
	 * @Stories({"[Story # 38] User views basic image attributes in Media Gallery"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminStandaloneMediaGalleryEditImageDetailsTest(AcceptanceTester $I, \Codeception\Scenario $scenario)
	{
		$scenario->skip("This test is skipped due to the following issues:\nUse AdminStandaloneMediaGalleryEditImageDetailsFromDialogTest instead");
	}
}
